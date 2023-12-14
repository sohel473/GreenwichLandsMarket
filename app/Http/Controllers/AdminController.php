<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{

    function handleImage(Request $request, Product $product)
    {
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

    public function showAdminPage(Request $request)
    {
        $activeTab = $request->get('tab', 'pictures'); // Get the active tab from the request, default to 'pictures'

        // Search for Pictures
        $pictureQuery = $request->input('picture_search');
        $pictures = Product::when($pictureQuery, function ($query) use ($pictureQuery) {
            return $query->where('name', 'LIKE', "%{$pictureQuery}%")
                ->orWhere('description', 'LIKE', "%{$pictureQuery}%");
        })->paginate(7);

        // Search for Orders
        $orderQuery = $request->input('order_search');
        $orders = Order::with('user')
            ->when($orderQuery, function ($query) use ($orderQuery) {
                return $query->whereHas('user', function ($q) use ($orderQuery) {
                    $q->where('username', 'LIKE', "%{$orderQuery}%");
                });
            })
            ->paginate(7);

        // Search for Customers
        $customerQuery = $request->input('customer_search');
        $customers = User::where('is_admin', false)
            ->when($customerQuery, function ($query) use ($customerQuery) {
                return $query->where('username', 'LIKE', "%{$customerQuery}%");
            })
            ->paginate(7);

        // Search for Admins
        $adminQuery = $request->input('admin_search');
        $admins = User::where('is_admin', true)
            ->when($adminQuery, function ($query) use ($adminQuery) {
                return $query->where('username', 'LIKE', "%{$adminQuery}%");
            })
            ->paginate(7);

        return view('admin/adminDashboard', [
            'title' => 'Admin Dashboard',
            'activeTab' => $activeTab,
            'pictures' => $pictures,
            'customers' => $customers,
            'admins' => $admins,
            'orders' => $orders,
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

    public function createPicture(Request $request)
    {
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

        return redirect('/picture/' . $product->id)->with('success', 'Picture created successfully.');
    }

    public function showEditPicturePage(Product $product)
    {
        return view('admin/pictureForm', [
            'product' => $product,
        ]);
    }

    public function updatePicture(Request $request, Product $product)
    {
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

        return redirect('/picture/' . $product->id)->with('success', 'Picture updated successfully.');
    }

    public function deletePicture(Product $product)
    {
        $product->delete();

        return redirect('/admin')->with('success', 'Picture deleted successfully.');
    }

    public function showCreateCustomerPage()
    {
        return view('admin/customerForm');
    }

    public function createCustomer(Request $request)
    {
        // Validate the request data
        $request->validate([
            'username' => ['required', 'min:3', 'max:255', Rule::unique('users', 'username')],
            'email' => ['max:255'],
            'password' => ['required', 'min:6', 'max:255', 'confirmed'],
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create an empty profile for the user
        $user->profile()->create([
            'user_id' => $user->id,

        ]);

        return redirect('/admin')->with('success', 'Customer created successfully.');
    }

    public function showEditCustomerPage(User $user)
    {
        return view('admin/customerForm', [
            'customer' => $user,
        ]);
    }

    public function updateCustomer(Request $request, User $user)
    {
        // Validate the request data
        $request->validate([
            'username' => ['required', 'min:3', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['max:255'],
            'password' => ['nullable', 'min:6', 'max:255', 'confirmed'],
        ]);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/admin')->with('success', 'Customer updated successfully.');
    }

    public function deleteCustomer(User $user)
    {
        $user->delete();

        return redirect('/admin')->with('success', 'Customer deleted successfully.');
    }

    public function showCreateAdminPage()
    {
        return view('admin/adminForm');
    }

    public function createAdmin(Request $request)
    {
        // Validate the request data
        $request->validate([
            'username' => ['required', 'min:3', 'max:255', Rule::unique('users', 'username')],
            'email' => ['max:255'],
            'password' => ['required', 'min:5', 'max:255', 'confirmed'],
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true,
        ]);

        // Create an empty profile for the user
        $user->profile()->create([
            'user_id' => $user->id,
        ]);

        return redirect('/admin')->with('success', 'Admin created successfully.');
    }

    public function showEditAdminPage(User $user)
    {
        return view('admin/adminForm', [
            'admin' => $user,
        ]);
    }

    public function updateAdmin(Request $request, User $user)
    {
        // Validate the request data
        $request->validate([
            'username' => ['required', 'min:3', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['max:255'],
            'password' => ['nullable', 'min:6', 'max:255', 'confirmed'],
        ]);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/admin')->with('success', 'Admin updated successfully.');
    }

    public function deleteAdmin(User $user)
    {
        $user->delete();

        return redirect('/admin')->with('success', 'Admin deleted successfully.');
    }

    public function downloadPicturesReport()
    {
        $pictures = Product::all();
        $pdf = PDF::loadView('reports.pictures', compact('pictures'));
        return $pdf->download('pictures_report.pdf');
    }

    public function downloadOrdersReport()
    {
        $orders = Order::all();
        $pdf = PDF::loadView('reports.orders', compact('orders'));
        return $pdf->download('orders_report.pdf');
    }

    public function downloadCustomersReport()
    {
        $customers = User::where('is_admin', false)->get();
        $pdf = PDF::loadView('reports.customers', compact('customers'));
        return $pdf->download('customers_report.pdf');
    }

    public function downloadAdminsReport()
    {
        $admins = User::where('is_admin', true)->get();
        $pdf = PDF::loadView('reports.admins', compact('admins'));
        return $pdf->download('admins_report.pdf');
    }
}
