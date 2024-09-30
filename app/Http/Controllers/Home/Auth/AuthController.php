<?php

namespace App\Http\Controllers\Home\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\Login\LoginRequest;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.home.login');
    }

    public function showForgotPassword()
    {
        return view('auth.home.forgot-password');
    }

    public function login(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::whereEmail($email)->where('status', 'active')->first();
        if($user){
            if (Auth::attempt(['email' => $email, 'password' => $password, 'user_type' => 'user', 'status' => 'active'])) {
                if ($request->has('redirectTo')) {
                    return redirect($request->input('redirectTo'));
                }
                return redirect()->route('home');
            }
            return back()->onlyInput('email')->withErrors(['error' => 'Invalid email or password']);
        } else {
            return back()->onlyInput('email')->withErrors(['error' => 'Your account is deactivated. To activate it please contact admin']);
        }
    }

    public function checkEmail(Request $request)
    {
        $email = $request->email ?? '';
        $user = User::whereEmail($email)->first();
        if($user){
            echo "true";
        } else {
            echo "false";
        }
        exit;
    }

    public function forgotPassword(Request $request)
    {

        $rules = [
            'email' => ['required', 'email'],
        ];

        $messages = [
            'email.required' => 'Please enter a email address',
            'email.email' => 'Please enter a valid email address',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
        $email = $request->email ?? '';
        $user = User::whereEmail($email)->first();
        if($user){
            $password = generateRandomPassword();
            User::whereEmail($email)->update(['password' => Hash::make($password)]);
            $loginLink = route('login');
            $data = ['email' => $email, 'password' => $password, 'loginLink' => $loginLink];
            Mail::to($email)->send(new PasswordResetMail($data));
            return response()->json(['status' => true, 'message' => "Password reset instructions have been sent to your email. Please check your inbox."]);
        }
        return response()->json(['status' => false, 'message' => 'This email address is not registered with us']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

}
