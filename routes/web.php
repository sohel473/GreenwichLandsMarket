<?php

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

Route::get('/', [App\Http\Controllers\UserController::class, 'showHomePage']);

// guest routes
Route::middleware('guest')->group(function () {
  // user routes
  // get routes
  Route::get('/login', [UserController::class, 'loginPage']);
  Route::get('/register', [UserController::class, 'registerPage']);
  // post routes
  Route::post('/login', [UserController::class, 'login']);
  Route::post('/register', [UserController::class, 'register']);
});

// auth routes
Route::middleware(('MustBeLoggedIn'))->group(function () {
  Route::post('/logout', [UserController::class, 'logout']);

  // // profile routes
  Route::get('/profile', [UserController::class, 'showProfilePage']);
  Route::put('/profile/{user}', [UserController::class, 'updateProfile'])->name('profile.update');
});
