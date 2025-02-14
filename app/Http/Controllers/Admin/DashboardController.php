<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        ];

        return view('user.dashboard', compact('page_title', 'stats', 'breadcrumbs'));
    }
}
