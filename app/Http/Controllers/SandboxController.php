<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
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
        event(new \App\Events\MessageSent('Hello, this is a real-time message!'));
        event(new \App\Events\MessageSent('This is the second message!'));
        // dd('hhh');
        event(new \App\Events\MessageSent('Check the last message here'));

        // broadcast(new MessageSent(['data' => 'Hello, this is a real-time message!']));

        return view('sandbox.index', compact('page_title', 'breadcrumbs'));
    }
}
