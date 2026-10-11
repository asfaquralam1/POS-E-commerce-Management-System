<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function index()
  {
    return view('admin.auth.login');
  }

  public function authenticate(Request $request)
  {
    $credentials = $request->only('email', 'password');

    if (auth()->guard('admin')->attempt($credentials)) {
      // Authentication passed...
      return redirect()->route('admin.dashboard');
    } else {
      return redirect()->back()->withErrors(['Invalid credentials']);
    }
  }

  public function dashboard()
  {
    $total_users = User::count();
    $total_admins = Admin::count();
    $total_products = Product::count();
    $total_categories = Category::count();
    $users = User::all();
    return view('admin.dashboard', compact('users','total_users', 'total_admins','total_products','total_categories'));
  }
}
