<?php

namespace App\Http\Controllers;

use App\Models\expenses;
use App\Models\Orders;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * Display the business overview dashboard.
     */
    public function index(): View
    {
        $supplierBalance = supplierBalance();
        $customerBalance = customerBalance();
        $checkpostBalance = checkpostBalance();
        $businessBalance = myBalance();

        $currentYear = date('Y');

        $lastOrders = Orders::orderBy('id', 'desc')->take(10)->get()->reverse();

        $chartLabels = [];
        $profitData = [];

        foreach ($lastOrders as $order) {
            $chartLabels[] = "Order #" . $order->id;
            $profitData[] = (float) $order->profit_loss;
        }

        $topCustomers = Orders::with('customer')
            ->selectRaw('customer_id, SUM(sale_amount) as total_sales')
            ->whereYear('date', $currentYear)
            ->groupBy('customer_id')
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get();

        return view('index', compact(
            'supplierBalance',
            'customerBalance',
            'checkpostBalance',
            'businessBalance',
            'chartLabels',
            'profitData',
            'topCustomers'
        ));
    }
}
