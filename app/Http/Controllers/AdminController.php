<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{

    function handleImage(Request $request, Product $product) {
        if ($request->hasFile('mainimage')) {

            // Generate the custom filename
            $filename = $product->name . '_' . time() . '.' . $request->mainimage->extension();
    
            // Log::info("Filename: " . $filename);

            $image = $request->file('mainimage');

            // Resize image
            $resizedImage = Image::make($image)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
    
            // Save the image
            $resizedImage->save(public_path('storage/landmarks/' . $filename));

            // Log::info("Filename: " . $filename);
    
            return $filename;
        }  
    }

    public function showAdminPage() {   
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

    public function showCreatePicturePage() {
        return view('admin/pictureForm');
    }

    public function showPicturePage(Product $product) {
        return view('admin/picture', [
            'product' => $product,
        ]);
    }

    public function createPicture(Request $request) {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'mainimage' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
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

    public function showEditPicturePage(Product $product) {
        return view('admin/pictureForm', [
            'product' => $product,
        ]);
    }

    public function updatePicture(Request $request, Product $product) {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'mainimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
        ]);

        // Update the product instance
        $product->update($validatedData);

        // Handle the image
        if ($request->hasFile('mainimage')) {
            $filename = $this->handleImage($request, $product);
            $product->mainimage = $filename;
        }

        // Save the product
        $product->save();

        return redirect('/admin')->with('success', 'Picture updated successfully.');
    }

    public function deletePicture(Product $product) {
        $product->delete();

        return redirect('/admin')->with('success', 'Picture deleted successfully.');
    }
    
}
