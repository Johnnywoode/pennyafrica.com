<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $page_title = __('locale.titles.dashboard');
        $breadcrumbs = [
            ['name' => $page_title],
        ];

        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', true)->count(),
            'total_transactions' => Transaction::count(),
            'credit_transactions' => Auth::user()->transactions()->where('type', Transaction::TYPE_CREDIT)->count(),
            'debit_transactions' => Auth::user()->transactions()->where('type', Transaction::TYPE_DEBIT)->count(),
        ];

        return view('user.dashboard', compact('page_title', 'stats', 'breadcrumbs'));
    }
}
