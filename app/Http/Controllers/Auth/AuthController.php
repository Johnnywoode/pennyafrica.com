<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('phone', preg_replace('/\D/', '', ($request->country_code ? $request->country_code . $request->phone : $request->phone)))->first();

        if(!$user){
            return redirect()->route('login')->with([
                'status'  => 'error',
                'message' => __('validation.custom.phone.invalid_login_credentials'),
            ])->withErrors(['phone' => __('validation.custom.phone.invalid_login_credentials')]);
        }

        Auth::login($user);

        return $user->isAdmin() ?
            redirect()->route(config('app.admin_path') . '.dashboard')->with([
                'status'  => 'success',
                'message' => __('locale.auth.welcome_come_back', ['name' => 'Admin '. $user->details->name]),
            ]) :
            redirect()->route('user.dashboard')->with([
            'status'  => 'success',
            'message' => __('locale.auth.welcome_come_back', ['name' => $user->details->name]),
        ]);
    }

    public function logout()
    {
        // $this->createActivityLog(ActivityLog::TYPE_LOGOUT, 'User logged out successfully');
        Auth::logout();
        return redirect()->route('login');
    }
}
