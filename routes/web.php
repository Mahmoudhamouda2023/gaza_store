<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProfileController as FrontendProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/products', [ProductController::class, 'index'])->name('frontend.products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('frontend.products.show');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('frontend.categories.show');

Route::middleware('auth')->group(function () {

    // Frontend User Profile
    Route::get('/my-profile', [FrontendProfileController::class, 'index'])
        ->name('frontend.profile.index');

    Route::patch('/my-profile/info', [FrontendProfileController::class, 'updateInfo'])
        ->name('frontend.profile.info.update');

    Route::post('/my-profile/image', [FrontendProfileController::class, 'updateImage'])
        ->name('frontend.profile.image.update');

    Route::delete('/my-profile/image', [FrontendProfileController::class, 'deleteImage'])
        ->name('frontend.profile.image.delete');

    // Default Breeze Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('frontend.cart.index');
    // Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('frontend.cart.store');
    Route::post('/cart/add', [CartController::class, 'add'])->name('frontend.cart.add')->middleware('auth');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('frontend.cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('frontend.cart.destroy');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('frontend.checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('frontend.checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('frontend.checkout.success');
    Route::get('/checkout/cancel/{order}', [CheckoutController::class, 'cancel'])->name('frontend.checkout.cancel');

    // Orders Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('frontend.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('frontend.orders.show');
});

Route::get('old-products', [ApiController::class, 'products']);
Route::get('weather', [ApiController::class, 'weather']);
Route::get('/send', [NotificationController::class, 'send']);

Route::post('/cart/add', [CartController::class, 'add'])->name('frontend.cart.add')->middleware('auth');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/webhook/stripe', [WebhookController::class, 'stripe'])->name('webhook.stripe');
Route::post('/webhook/fawateri', [WebhookController::class, 'fawateri'])->name('webhook.fawateri');
require __DIR__ . '/auth.php';
