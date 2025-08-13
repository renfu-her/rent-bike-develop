<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MotorcycleController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Auth\MemberAuthController;
use App\Http\Controllers\MemberProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;

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
Route::post('/motorcycles/{id}/rent', [MotorcycleController::class, 'storeRent'])->name('motorcycles.rent.store')->middleware('auth:member');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{motorcycleId}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{cartDetailId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cartDetailId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/process-checkout', [CartController::class, 'processCheckout'])->name('cart.processCheckout')->middleware('auth:member');

// Payment routes
Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process')->middleware('auth:member');
Route::post('/payment/notify', [PaymentController::class, 'notify'])->name('payment.notify');
Route::match(['GET', 'POST'], '/payment/result', [PaymentController::class, 'result'])->name('payment.result');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

// Store routes
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/{id}', [StoreController::class, 'show'])->name('stores.show');

// Contact page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Profile routes
Route::get('/profile', [MemberProfileController::class, 'show'])->name('profile.show')->middleware('auth:member');
Route::put('/profile', [MemberProfileController::class, 'update'])->name('profile.update')->middleware('auth:member');

// Orders page (placeholder)
Route::get('/orders', function () {
    return view('orders.index');
})->name('orders.index');

// Test CSRF exception
Route::post('/test-csrf', function () {
    return response()->json(['message' => 'CSRF test successful']);
})->name('test.csrf');

// Test CSRF page
Route::get('/test-csrf-page', function () {
    return view('test-csrf');
})->name('test.csrf.page');


