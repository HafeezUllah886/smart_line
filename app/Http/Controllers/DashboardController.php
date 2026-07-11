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

        $ordersProfit = Orders::selectRaw('MONTH(date) as month, SUM(profit_loss) as total_profit')
            ->whereYear('date', $currentYear)
            ->groupBy('month')
            ->get()->keyBy('month');

        $expensesProfit = expenses::selectRaw('MONTH(date) as month, SUM(amount) as total_expense')
            ->whereYear('date', $currentYear)
            ->groupBy('month')
            ->get()->keyBy('month');

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $profitData = [];

        for ($i = 1; $i <= 12; $i++) {
            $op = isset($ordersProfit[$i]) ? $ordersProfit[$i]->total_profit : 0;
            $ep = isset($expensesProfit[$i]) ? $expensesProfit[$i]->total_expense : 0;
            $profitData[] = $op - $ep;
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
            'months',
            'profitData',
            'topCustomers'
        ));
    }
}
