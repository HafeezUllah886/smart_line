<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\drivers;
use App\Models\Orders;
use App\Models\products;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        return view('orders.create', compact('customers', 'suppliers', 'checkposts', 'accounts', 'products', 'drivers'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $orders)
    {
        //
    }

    public function getCheckPost($id)
    {
        $checkpost = accounts::find($id);

        return response()->json($checkpost);
    }
}
