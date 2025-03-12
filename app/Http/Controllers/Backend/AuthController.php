<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginUserRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login()
    {
        return view('backend.auth.login');
    }

    public function authenticate(Request $request)
    {

        Validator::make(
            $request->all(),
            [
                'email'                 => 'required|email|exists:users,email',
                'password'              => 'required|min:6|max:20',
                'g-recaptcha-response'  => 'required'
            ],
            [
                __('request.messages')
            ],
            [
                'email'                 => 'Email',
                'password'              => 'Mật khẩu',
                'g-recaptcha-response'  => 'reCaptcha',
            ]
        );

        $credentials = $request->only(['email', 'password']);

        $remember = $request->boolean('remember');

        if (auth()->attempt($credentials, $remember)) {

            sessionFlash('success', 'Đăng nhập thành công.');
            return redirect()->route('admin.dashboard');
        } else {
            sessionFlash('error', 'Tài khoản hoặc mật khẩu không chính xác!');
            return back()->withInput();
        }
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('admin.auth.login');
    }
}
