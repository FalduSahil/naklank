<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $products = Product::whereStatus('pending')->count();
        $users = User::where('user_type', '!=', 'admin')->count();
        return view('admin.dashboard', compact(['products','users']));
    }
}
