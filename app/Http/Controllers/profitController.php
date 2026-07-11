<?php

namespace App\Http\Controllers;

use App\Models\expenses;
use App\Models\Orders;
use Illuminate\Http\Request;

class profitController extends Controller
{
    public function index()
    {
        return view('reports.profit.index');
    }

    public function details(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $orders = Orders::with(['expenses', 'product'])->whereBetween('date', [$from, $to])->get();
        $expenses = expenses::whereBetween('date', [$from, $to])->sum('amount');

        return view('reports.profit.details', compact('from', 'to', 'orders', 'expenses'));
    }
}
