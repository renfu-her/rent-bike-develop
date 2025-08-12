<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MotorcycleController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Auth\MemberAuthController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

// Member Authentication Routes
Route::get('/login', [MemberAuthController::class, 'showLoginForm'])->name('member.login');
Route::post('/login', [MemberAuthController::class, 'login']);
Route::get('/register', [MemberAuthController::class, 'showRegistrationForm'])->name('member.register');
Route::post('/register', [MemberAuthController::class, 'register']);
Route::post('/logout', [MemberAuthController::class, 'logout'])->name('member.logout');


// Motorcycle routes
Route::get('/motorcycles', [MotorcycleController::class, 'index'])->name('motorcycles.index');
Route::get('/motorcycles/{id}/rent', [MotorcycleController::class, 'rent'])->name('motorcycles.rent');

// Store routes
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/{id}', [StoreController::class, 'show'])->name('stores.show');

// Contact page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Profile page (placeholder)
Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Orders page (placeholder)
Route::get('/orders', function () {
    return view('orders.index');
})->name('orders.index');


