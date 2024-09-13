<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Login\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin.admin-login');
    }

    public function login(AdminLoginRequest $request)
    {
        $email = $request->email ?? '';
        $password = $request->password ?? '';

        if (Auth::attempt(['email' => $email, 'password' => $password, 'user_type' => 'admin'])) {
            return redirect('/admin/dashboard');
        }
        return back()->onlyInput('email')->withErrors(['error' => 'Invalid email or password']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
