<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * Display the business overview dashboard.
     */
    public function index(): View
    {
        return view('index');
    }
}
