<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    function handleImage(Request $request, Product $product) {
        if ($request->hasFile('mainimage')) {

            // Generate the custom filename
            $filename = $product->name . '_' . time() . '.' . $request->mainimage->extension();
    
            // Log::info("Filename: " . $filename);
    
            // Store the file in the 'public/photographs' directory
            $request->mainimage->storeAs('landmarks', $filename, 'public');

            // Log::info("Filename: " . $filename);
    
            return $filename;
        }  
    }

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

    public function showCreatePicturePage()
    {
        return view('admin/pictureForm');
    }

    public function showPicturePage(Product $product)
    {
        return view('admin/picture', [
            'product' => $product,
        ]);
    }

    public function createPicture(Request $request) {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'mainimage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
        ]);

        // Create a new product instance
        $product = new Product($validatedData);

        // Handle the image
        if ($request->hasFile('mainimage')) {
            $filename = $this->handleImage($request, $product);
            $product->mainimage = $filename;
        }

        // Save the product
        $product->save();

        return redirect('/admin')->with('success', 'Picture created successfully.');
    }


    
}
