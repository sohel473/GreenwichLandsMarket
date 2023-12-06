<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\UserController::class, 'showHomePage'])->name('home');

// guest routes
Route::middleware('guest')->group(function () {
  // user routes
  // get routes
  Route::get('/login', [UserController::class, 'loginPage'])->name('login');
  Route::get('/register', [UserController::class, 'registerPage']);
  // post routes
  Route::post('/login', [UserController::class, 'login']);
  Route::post('/register', [UserController::class, 'register']);

});

// auth routes
Route::middleware(('MustBeLoggedIn'))->group(function () {
  Route::post('/logout', [UserController::class, 'logout']);

  // // profile routes
  Route::get('/profile/{user}', [UserController::class, 'showProfilePage']);
  Route::put('/profile/{user}', [UserController::class, 'updateProfile'])->name('profile.update');

  // // picture routes
  Route::get('/picture/{product}', [AdminController::class, 'showPicturePage'])->name('pictures.show');

  // // cart routes
  Route::get('/cart', [UserController::class, 'showCartPage']);
});

// admin routes
Route::middleware('can:admin-access')->group(function () {
  Route::get('/admin', [AdminController::class, 'showAdminPage']);

  // product routes
  Route::get('/create-picture', [AdminController::class, 'showCreatePicturePage']);
  Route::post('/picture', [AdminController::class, 'createPicture'])->name('pictures.store');
  Route::get('/picture/{product}/edit', [AdminController::class, 'showEditPicturePage']);
  Route::put('/picture/{product}', [AdminController::class, 'updatePicture'])->name('pictures.update');
  Route::delete('/picture/{product}', [AdminController::class, 'deletePicture']);

  // customer routes
  Route::get('/create-customer', [AdminController::class, 'showCreateCustomerPage'])->name('customers.create');
  Route::post('/customer', [AdminController::class, 'createCustomer'])->name('customers.store');
  Route::get('/customer/{user}/edit', [AdminController::class, 'showEditCustomerPage'])->name('customers.edit');
  Route::put('/customer/{user}', [AdminController::class, 'updateCustomer'])->name('customers.update');
  Route::delete('/customer/{user}', [AdminController::class, 'deleteCustomer'])->name('customers.destroy');

  // admin routes
  Route::get('/create-admin', [AdminController::class, 'showCreateAdminPage'])->name('admins.create');
  Route::post('/admin', [AdminController::class, 'createAdmin'])->name('admins.store');
  Route::get('/admin/{user}/edit', [AdminController::class, 'showEditAdminPage'])->name('admins.edit');
  Route::put('/admin/{user}', [AdminController::class, 'updateAdmin'])->name('admins.update');
  Route::delete('/admin/{user}', [AdminController::class, 'deleteAdmin'])->name('admins.destroy');
  
});

// cart routes
Route::middleware(['auth'])->group(function () {
  Route::post('/cart/add/{productId}', [OrderController::class, 'addToCart'])->name('cart.add');
  Route::get('/cart', [OrderController::class, 'viewCart'])->name('cart.view');
  Route::post('/cart/remove/{productId}', [OrderController::class, 'removeFromCart'])->name('cart.remove');
  Route::post('/cart/change-quantity/{productId}/{changeType}', [OrderController::class, 'changeCartItemQuantity'])->name('cart.changeQuantity');
});