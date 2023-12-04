<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showAdminPage()
    {   
        $activeTab = 'pictures'; // default active tab, can be changed to 'users' or 'admin' or 'pictures
        $pictures = Product::all();
        $customers = User::where('is_admin', false)->get();
        $admins = User::where('is_admin', true)->get();

        return view('admin/adminDashboard', [
            'title' => 'Admin Dashboard',
            'activeTab' => $activeTab,
            'pictures' => $pictures,
            'customers' => $customers,
            'admins' => $admins,
        ]);
    }
}
