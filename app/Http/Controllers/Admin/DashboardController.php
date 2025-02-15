<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $page_title = 'Dashboard';
        $breadcrumbs = [
            ['name' => $page_title],
        ];

        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', true)->count(),
            'total_transactions' => Transaction::count(),
            'credit_transactions' => Transaction::where('type', Transaction::TYPE_CREDIT)->count(),
            'debit_transactions' => Transaction::where('type', Transaction::TYPE_DEBIT)->count(),
        ];

        return view('admin.dashboard', compact('page_title', 'stats', 'breadcrumbs'));
    }
}
