<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user && $user->role_id==1) {
            // Trả về view home cho admin
            return view('home');
        } else {
            // Nếu không phải admin, chuyển về index
            return redirect()->route('index');
        }
    }
}