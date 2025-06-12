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

        // Kiểm tra bảng users (email hoặc username)
        $user = User::where('email', $request->email)
            ->orWhere('username', $request->email)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('index');
        }

        // Kiểm tra bảng admins (username hoặc email nếu có)
        $admin = DB::table('admins')
            ->where('username', $request->email)
            ->first();

        // So sánh mật khẩu plain text cho admin
        if ($admin && $request->password === $admin->password) {
            session(['admin' => $admin]);
            return redirect()->route('/home');
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
