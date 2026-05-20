<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DeliveryChargeController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WebsiteSettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'home'])->name('home');

Route::name('shop.')->group(function () {
    Route::get('/products', [ShopController::class, 'products'])->name('products');
    Route::get('/product/{slug}', [ShopController::class, 'productDetail'])->name('product-detail');
    Route::get('/category/{slug}', [ShopController::class, 'category'])->name('category');
});

Route::name('cart.')->prefix('/cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add')->middleware('throttle:30,1');
    Route::post('/update', [CartController::class, 'update'])->name('update')->middleware('throttle:30,1');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

Route::name('contact.')->group(function () {
    Route::get('/contact', [ContactController::class, 'index'])->name('index');
    Route::post('/contact', [ContactController::class, 'store'])->name('store');
});

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])
    ->name('checkout.place')
    ->middleware('throttle:10,1');
Route::get('/checkout/confirmation/{order}', [CheckoutController::class, 'confirmation'])
    ->name('shop.confirmation');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class)->except(['show']);

        Route::patch('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
            ->name('categories.toggle-status');

        Route::resource('products', ProductController::class)->except(['show']);

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.update-status');
        Route::get('/orders/{order}/invoice', [InvoiceController::class, 'print'])
            ->name('orders.invoice');

        Route::resource('contacts', ContactMessageController::class)->parameters(['contacts' => 'contactMessage'])->only(['index', 'show', 'destroy']);

        Route::resource('delivery-charges', DeliveryChargeController::class)->except(['show']);

        Route::get('/settings', [WebsiteSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [WebsiteSettingController::class, 'update'])->name('settings.update');
        Route::post('/settings/delete-image', [WebsiteSettingController::class, 'deleteImage'])->name('settings.delete-image');

        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', UserController::class);
    });

    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});
