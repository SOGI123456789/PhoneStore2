<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->load('role');
            if ($user && $user->role && $user->role->name === 'admin') {
                return redirect()->route('home');
            } else {
                return redirect()->route('index');
            }
        }

        // Kiểm tra bảng users (email hoặc username)
        $user = User::where('email', $request->email)
            ->orWhere('username', $request->email)
            ->first();

        // Sử dụng Hash::check để kiểm tra mật khẩu mã hóa
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            if ($user->role_id == 1) { // 1 là admin
                return redirect()->route('home');
            } else {
                return redirect()->route('index');
            }
        }

        return back()->withErrors(['email' => 'Tài khoản hoặc mật khẩu không đúng!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        session()->forget('admin');
        return redirect()->route('login');
    }
}
