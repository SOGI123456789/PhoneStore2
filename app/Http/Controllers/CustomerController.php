<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // Bỏ constructor middleware

    // Hiển thị thông tin cá nhân
    public function index()
    {
        $user = Auth::user();
        return view('customer.index', compact('user'));
    }

    // Hiển thị form chỉnh sửa
    public function edit()
    {
        $user = Auth::user();
        return view('customer.edit', compact('user'));
    }

    // Cập nhật thông tin
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập họ tên',
            'name.max' => 'Họ tên không được vượt quá 255 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã được sử dụng',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự',
            'address.max' => 'Địa chỉ không được vượt quá 500 ký tự',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'current_password.required_with' => 'Vui lòng nhập mật khẩu hiện tại để đổi mật khẩu mới',
        ]);

        // Kiểm tra mật khẩu hiện tại nếu muốn đổi mật khẩu
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng'])
                           ->withInput();
            }
            // Thêm mật khẩu mới vào dữ liệu cập nhật
            $validated['password'] = Hash::make($request->password);
        } else {
            // Loại bỏ các trường password khỏi dữ liệu cập nhật
            unset($validated['password'], $validated['current_password']);
        }

        // Cập nhật thông tin user
        $user->update($validated);

        return redirect()->route('customer.index')->with('success', 'Cập nhật thông tin thành công!');
    }
}