<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {

        if (Auth::attempt($request->only('phone', 'password'))) {
            // $this->createActivityLog(ActivityLog::TYPE_LOGIN, 'User logged in successfully');
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['phone' => 'Invalid credentials.']);
    }

    public function logout()
    {
        // $this->createActivityLog(ActivityLog::TYPE_LOGOUT, 'User logged out successfully');
        Auth::logout();
        return redirect()->route('login');
    }
}
