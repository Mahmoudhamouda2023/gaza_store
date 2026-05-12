<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::prefix(LaravelLocalization::setLocale())->group(function () {
    Route::prefix('admin')->name('admin.')->middleware('auth', 'isAdmin', 'verified')->group(function () {
        // عرض صفحة الـ Admin الرئيسية
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // عرض صفحة الـ Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');

        // تحديث البيانات الشخصية باستخدام PUT
        Route::post('/profile', [AdminController::class, 'profile_data'])->name('profile_data');
        // المسار الخاص بـ Categories
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications');
        Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    });
});
