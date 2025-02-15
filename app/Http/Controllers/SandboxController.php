<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SandboxController extends Controller
{
    public function index()
    {
        $page_title = __('locale.titles.sandbox');
        $breadcrumbs = [
            ['name' => $page_title],
        ];

        $user = Auth::user();

        return view('sandbox.index', compact('page_title', 'breadcrumbs'));
    }
}
