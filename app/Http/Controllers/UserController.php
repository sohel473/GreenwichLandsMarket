<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;


class UserController extends Controller
{

    function handlePhotograph(Request $request, User $user) {
        if ($request->hasFile('photograph')) {

            // Generate the custom filename
            $filename = $user->id . '_' . $user->username . '_' . time() . '.' . $request->photograph->extension();
    
            // Log::info("Filename: " . $filename);
    
            // Store the file in the 'public/photographs' directory
            $request->photograph->storeAs('photographs', $filename, 'public');

            // Log::info("Filename: " . $filename);
    
            return $filename;
        }  
    }

    public function showHomePage() {
        $pictures = Product::paginate(6);
        
        return view('home', [
            'pictures' => $pictures,
        ]);
    }

    public function registerPage() {
        return view('auth/register');
    }

    public function register(Request $request) {
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

        Auth::login($user);

        session()->flash('success', 'You have been registered and login successfully.');

        return redirect('/');
    }

    public function loginPage() {
        return view('auth/login');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Log the user in
            Auth::login($user);

            $request->session()->regenerate();

            
            session()->flash('success', 'You have been logged in successfully.');
            return redirect('/');

        }

        session()->flash('error', 'The provided credentials do not match our records.');

        return back()->withInput($request->only('username'));
    }

    public function logout(Request $request) {
        Auth::logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->flash('success', 'You have been logged out successfully.');
    
        return redirect('/');
    }

    public function showProfilePage() {
        return view('auth/profile',[
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request, User $user) {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'date_of_birth' => ['nullable', 'date'],
            // Add validation for the photograph if needed
        ]);

        // Handle photograph upload
        $photograph = $this->handlePhotograph($request, $user);
    
        // Update the user's profile
        $user->profile->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'telephone' => $request->telephone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'photograph' => $photograph ?:$user->profile->getRawOriginal('photograph'),
        ]);
    
        // If password change is requested, validate and update it
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
    
        session()->flash('success', 'Your profile has been updated successfully.');
    
        return back();
    }

    public function showCartPage() {
        $cartExists = true;
        return view('cart/cart', [
            'cartExists' => $cartExists,
        ]);
    }
    
}
