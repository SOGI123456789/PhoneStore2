<?php


namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('Roles.index', compact('users'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = \App\Models\Role::all();
        return view('Roles.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->save();
        return redirect()->route('roles.index')->with('success', 'Cập nhật quyền thành công!');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('roles.index')->with('success', 'Xóa tài khoản thành công!');
    }
}