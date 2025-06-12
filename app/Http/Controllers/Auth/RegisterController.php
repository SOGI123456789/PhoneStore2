<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username'      => 'required|string|max:100|unique:users',
            'email'         => 'required|string|email|max:100|unique:users',
            'password'      => 'required|string|min:6|confirmed',
            'phone_number'  => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'username'      => $request->username,
            'email'         => $request->email,
            'password' => Hash::make($request->password),
            'phone_number'  => $request->phone_number,
            'role_id'       => 2, // Mặc định là user
        ]);
        Auth::login($user);

        return redirect('/')->with('success', 'Đăng ký thành công!');
    }
}