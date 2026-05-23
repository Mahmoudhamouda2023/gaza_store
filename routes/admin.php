<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\RoleController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath',
    ],
], function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::middleware('guest:admin')->group(function () {
            Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
            Route::post('/login', [AuthController::class, 'login'])->name('login.post');
        });

        Route::middleware(['auth:admin'])->group(function () {

            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

            Route::get('/', [AdminController::class, 'index'])->name('index');

            Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
            Route::post('/profile', [AdminController::class, 'profile_data'])->name('profile_data');

            Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications');

            // ==================== Categories ====================

            Route::middleware('permission:view categories,admin')->group(function () {
                Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
            });

            Route::middleware('permission:create categories,admin')->group(function () {
                Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
                Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
            });

            Route::middleware('permission:edit categories,admin')->group(function () {
                Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
                Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
                Route::patch('/categories/{category}', [CategoryController::class, 'update']);
            });

            Route::middleware('permission:delete categories,admin')->group(function () {
                Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
            });

            // ==================== Products ====================
            Route::middleware('permission:view products,admin')->group(function () {
                Route::get('/products', [ProductController::class, 'index'])->name('products.index'); // الصفحة تعرض DataTable مباشرة
                Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
            });

            Route::middleware('permission:create products,admin')->group(function () {
                Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
                Route::post('/products', [ProductController::class, 'store'])->name('products.store');
            });

            Route::middleware('permission:edit products,admin')->group(function () {
                Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
                Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
                Route::patch('/products/{product}', [ProductController::class, 'update']);
            });

            Route::middleware('permission:delete products,admin')->group(function () {
                Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
            });

            // ==================== Orders ====================

            Route::middleware('permission:view orders,admin')->group(function () {
                Route::get('/orders', [OrderController::class, 'index'])->name('orders');
                Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
            });

            Route::middleware('permission:edit orders,admin')->group(function () {
                Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
            });

            // ==================== Payments ====================

            Route::middleware('permission:view payments,admin')->group(function () {
                Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
                Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
            });

            // ==================== Customers ====================

            Route::middleware('permission:view customers,admin')->group(function () {
                Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
            });

            // ==================== Roles ====================

            Route::middleware('permission:view roles,admin')->group(function () {
                Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
                Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
            });

            Route::middleware('permission:create roles,admin')->group(function () {
                Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
                Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
            });

            Route::middleware('permission:edit roles,admin')->group(function () {
                Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
                Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
            });

            Route::middleware('permission:delete roles,admin')->group(function () {
                Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
            });

            // ==================== Managers ====================

            Route::middleware('permission:view managers,admin')->group(function () {
                Route::get('/managers', [ManagerController::class, 'index'])->name('managers.index');
            });

            Route::middleware('permission:create managers,admin')->group(function () {
                Route::get('/managers/create', [ManagerController::class, 'create'])->name('managers.create');
                Route::post('/managers', [ManagerController::class, 'store'])->name('managers.store');
            });

            Route::middleware('permission:edit managers,admin')->group(function () {
                Route::get('/managers/{manager}/edit', [ManagerController::class, 'edit'])->name('managers.edit');
                Route::put('/managers/{manager}', [ManagerController::class, 'update'])->name('managers.update');
                Route::patch('/managers/{manager}', [ManagerController::class, 'update']);
            });

            Route::middleware('permission:delete managers,admin')->group(function () {
                Route::delete('/managers/{manager}', [ManagerController::class, 'destroy'])->name('managers.destroy');
            });

            // ==================== Employees ====================

            Route::middleware('permission:view employees,admin')->group(function () {
                Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
            });

            Route::middleware('permission:create employees,admin')->group(function () {
                Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
                Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
            });

            Route::middleware('permission:edit employees,admin')->group(function () {
                Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
                Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
                Route::patch('/employees/{employee}', [EmployeeController::class, 'update']);
            });

            Route::middleware('permission:delete employees,admin')->group(function () {
                Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
            });

            // ==================== Activity Logs ====================

            Route::middleware('role:admin,admin')->group(function () {
                Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('activity.logs');
            });
        });
    });
});
