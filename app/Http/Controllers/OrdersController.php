<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\drivers;
use App\Models\expenseCategories;
use App\Models\OrderExpenses;
use App\Models\OrderExtraExpense;
use App\Models\Orders;
use App\Models\products;
use App\Models\transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $from = $request->from ?? date('Y-m-01');
        $to = $request->to ?? date('Y-m-t');

        $supplier = $request->supplier ?? 'all';
        $customer = $request->customer ?? 'all';

        $orders = Orders::whereBetween('date', [$from, $to]);

        if ($supplier != 'all') {
            $orders->where('supplier_id', $supplier);
        }

        if ($customer != 'all') {
            $orders->where('customer_id', $customer);
        }

        $orders = $orders->get();

        $suppliers = accounts::active()->supplier()->get();
        $customers = accounts::active()->customer()->get();

        return view('orders.index', compact('orders', 'suppliers', 'customers', 'from', 'to', 'supplier', 'customer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = accounts::active()->customer()->get();
        $suppliers = accounts::active()->supplier()->get();
        $checkposts = accounts::active()->checkPost()->get();
        $accounts = accounts::active()->business()->get();
        $products = products::active()->get();
        $drivers = drivers::active()->get();
        $expenseCategories = expenseCategories::all();

        return view('orders.create', compact('customers', 'suppliers', 'checkposts', 'accounts', 'products', 'drivers', 'expenseCategories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $ref = getRef();

            $order = Orders::create([
                'date' => $request->date,
                'product_id' => $request->product,
                'driver_id' => $request->driver,
                'vehicle_no' => $request->vehicle_no,
                'supplier_id' => $request->supplier,
                'purchase_price' => $request->purchase_price,
                'purchase_qty' => $request->purchase_qty,
                'purchase_amount' => $request->purchase_amount,
                'purchase_account_id' => $request->purchase_account,
                'customer_id' => $request->customer,
                'sale_price' => $request->sale_price,
                'sale_qty' => $request->sale_qty,
                'sale_amount' => $request->sale_amount,
                'sale_account_id' => $request->sale_account,
                'route_expense' => 0,
                'profit_loss' => 0,
                'notes' => $request->notes,
                'refID' => $ref,
            ]);

            $route_expense = 0;
            if ($request->has('post_id')) {
                foreach ($request->post_id as $key => $post_id) {
                    $amount = $request->post_amount[$key];
                    $payment = $request->post_payment[$key];

                    OrderExpenses::create([
                        'order_id' => $order->id,
                        'post_id' => $post_id,
                        'amount' => $amount,
                        'payment' => $payment,
                        'refID' => $ref,
                    ]);

                    $route_expense += $amount;

                    if ($payment == 'pending') {
                        createTransaction($post_id, $request->date, 0, $amount, 'Pending Amount of Order No. '.$order->id, $ref);
                    } else {
                        createTransaction($post_id, $request->date, $amount, $amount, 'Payment of Order No. '.$order->id, $ref);
                    }
                }
            }

            if ($request->has('expense_category_id')) {
                foreach ($request->expense_category_id as $key => $category_id) {
                    if ($category_id) {
                        $amount = $request->expense_amount[$key] ?? 0;
                        $notes = $request->expense_notes[$key] ?? '';
                        $account_id = $request->expense_account[$key];

                        OrderExtraExpense::create([
                            'order_id' => $order->id,
                            'expense_category_id' => $category_id,
                            'account_id' => $account_id,
                            'amount' => $amount,
                            'notes' => $notes,
                            'refID' => $ref,
                        ]);

                        $category = expenseCategories::find($category_id);
                        $category_title = $category ? $category->name : '';
                        createTransaction($account_id, $request->date, 0, $amount, 'Expense of '.$category_title.' for Order No. '.$order->id, $ref);

                        $route_expense += $amount;
                    }
                }
            }

            $profit_loss = $request->sale_amount - $request->purchase_amount - $route_expense;

            $order->update([
                'route_expense' => $route_expense,
                'profit_loss' => $profit_loss,
            ]);

            if ($request->purchase_account != null) {
                createTransaction($request->supplier, $request->date, $request->purchase_amount, $request->purchase_amount, 'Payment of Order No. '.$order->id, $ref);
                createTransaction($request->purchase_account, $request->date, 0, $request->purchase_amount, 'Payment of Order No. '.$order->id, $ref);
            } else {
                createTransaction($request->supplier, $request->date, 0, $request->purchase_amount, 'Pending Amount of Order No. '.$order->id, $ref);
            }

            if ($request->sale_account != null) {
                createTransaction($request->customer, $request->date, $request->sale_amount, $request->sale_amount, 'Payment of Order No. '.$order->id, $ref);
                createTransaction($request->sale_account, $request->date, $request->sale_amount, 0, 'Payment of Order No. '.$order->id, $ref);
            } else {
                createTransaction($request->customer, $request->date, $request->sale_amount, 0, 'Pending Amount of Order No. '.$order->id, $ref);
            }

            DB::commit();

            return back()->with('success', 'Order Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Orders::with(['expenses.post', 'extraExpenses.category', 'supplier', 'customer', 'product', 'driver', 'purchaseAccount', 'saleAccount'])->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Orders::with(['expenses.post', 'extraExpenses.category'])->findOrFail($id);
        $customers = accounts::active()->customer()->get();
        $suppliers = accounts::active()->supplier()->get();
        $checkposts = accounts::active()->checkPost()->get();
        $accounts = accounts::active()->business()->get();
        $products = products::active()->get();
        $drivers = drivers::active()->get();
        $expenseCategories = expenseCategories::all();

        return view('orders.edit', compact('order', 'customers', 'suppliers', 'checkposts', 'accounts', 'products', 'drivers', 'expenseCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            \DB::beginTransaction();

            $order = Orders::findOrFail($id);
            $ref = $order->refID;

            // Delete old transactions
            transactions::where('refID', $ref)->delete();
            OrderExpenses::where('order_id', $order->id)->delete();

            $route_expense = 0;
            if ($request->has('post_id')) {
                foreach ($request->post_id as $key => $post_id) {
                    $amount = $request->post_amount[$key];
                    $payment = $request->post_payment[$key];

                    OrderExpenses::create([
                        'order_id' => $order->id,
                        'post_id' => $post_id,
                        'amount' => $amount,
                        'payment' => $payment,
                        'refID' => $ref,
                    ]);

                    $route_expense += $amount;

                    if ($payment == 'pending') {
                        createTransaction($post_id, $request->date, 0, $amount, 'Pending Amount of Order No. '.$order->id, $ref);
                    } else {
                        createTransaction($post_id, $request->date, $amount, $amount, 'Payment of Order No. '.$order->id, $ref);
                    }
                }
            }

            OrderExtraExpense::where('order_id', $order->id)->delete();
            if ($request->has('expense_category_id')) {
                foreach ($request->expense_category_id as $key => $category_id) {
                    if ($category_id) {
                        $amount = $request->expense_amount[$key] ?? 0;
                        $notes = $request->expense_notes[$key] ?? '';
                        $account_id = $request->expense_account[$key];

                        OrderExtraExpense::create([
                            'order_id' => $order->id,
                            'expense_category_id' => $category_id,
                            'account_id' => $account_id,
                            'amount' => $amount,
                            'notes' => $notes,
                            'refID' => $ref,
                        ]);

                        $category = expenseCategories::find($category_id);
                        $category_title = $category ? $category->name : '';
                        createTransaction($account_id, $request->date, 0, $amount, 'Expense of '.$category_title.' for Order No. '.$order->id, $ref);

                        $route_expense += $amount;
                    }
                }
            }

            $profit_loss = $request->sale_amount - $request->purchase_amount - $route_expense;

            $order->update([
                'date' => $request->date,
                'product_id' => $request->product,
                'driver_id' => $request->driver,
                'vehicle_no' => $request->vehicle_no,
                'supplier_id' => $request->supplier,
                'purchase_price' => $request->purchase_price,
                'purchase_qty' => $request->purchase_qty,
                'purchase_amount' => $request->purchase_amount,
                'purchase_account_id' => $request->purchase_account,
                'customer_id' => $request->customer,
                'sale_price' => $request->sale_price,
                'sale_qty' => $request->sale_qty,
                'sale_amount' => $request->sale_amount,
                'sale_account_id' => $request->sale_account,
                'route_expense' => $route_expense,
                'profit_loss' => $profit_loss,
                'notes' => $request->notes,
            ]);

            if ($request->purchase_account != null) {
                createTransaction($request->supplier, $request->date, $request->purchase_amount, $request->purchase_amount, 'Payment of Order No. '.$order->id, $ref);
                createTransaction($request->purchase_account, $request->date, 0, $request->purchase_amount, 'Payment of Order No. '.$order->id, $ref);
            } else {
                createTransaction($request->supplier, $request->date, 0, $request->purchase_amount, 'Pending Amount of Order No. '.$order->id, $ref);
            }

            if ($request->sale_account != null) {
                createTransaction($request->customer, $request->date, $request->sale_amount, $request->sale_amount, 'Payment of Order No. '.$order->id, $ref);
                createTransaction($request->sale_account, $request->date, $request->sale_amount, 0, 'Payment of Order No. '.$order->id, $ref);
            } else {
                createTransaction($request->customer, $request->date, $request->sale_amount, 0, 'Pending Amount of Order No. '.$order->id, $ref);
            }

            \DB::commit();

            return redirect()->route('orders.index')->with('success', 'Order Updated Successfully');
        } catch (\Exception $e) {
            \DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            \DB::beginTransaction();

            $order = Orders::findOrFail($id);
            $ref = $order->refID;

            // Delete transactions and expenses linked to this order
            transactions::where('refID', $ref)->delete();
            OrderExpenses::where('order_id', $order->id)->delete();
            OrderExtraExpense::where('order_id', $order->id)->delete();

            // Delete the order itself
            $order->delete();

            \DB::commit();
            session()->forget('confirmed_password');

            return redirect()->route('orders.index')->with('success', 'Order Deleted Successfully');
        } catch (\Exception $e) {
            \DB::rollBack();
            session()->forget('confirmed_password');

            return redirect()->route('orders.index')->with('error', $e->getMessage());
        }
    }

    public function getCheckPost($id)
    {
        $checkpost = accounts::find($id);

        return response()->json($checkpost);
    }
}
