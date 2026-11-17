<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminAuthMiddleware;
use Illuminate\Support\Facades\Route;

// Public Front-end Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['bn', 'en'])) {
        session(['locale' => $locale]);
        cookie()->queue(cookie()->forever('locale', $locale));
    }
    return response()->json(['success' => true, 'locale' => $locale]);
})->name('set.locale');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');
Route::get('/product/{slug}', [HomeController::class, 'product'])->name('product.show');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/track-order', [HomeController::class, 'trackOrder'])->name('track.order');

// Shopping Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/keep-only/{id}', [CartController::class, 'keepOnly'])->name('cart.keep_only');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout & Order Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order-success/{order_number}', [CheckoutController::class, 'success'])->name('order.success');

// Admin Authentication (Public Login Form & Submit)
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Protected Admin Panel Routes (Only accessible with Admin Login)
Route::middleware([AdminAuthMiddleware::class])->prefix('admin')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // 1. Orders & Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/orders/create', [AdminController::class, 'orderCreate'])->name('admin.orders.create');
    Route::post('/orders/store', [AdminController::class, 'orderStore'])->name('admin.orders.store');
    Route::get('/orders/{id}', [AdminController::class, 'show'])->name('admin.orders.show');
    Route::get('/orders/{id}/edit', [AdminController::class, 'orderEdit'])->name('admin.orders.edit');
    Route::post('/orders/{id}/update', [AdminController::class, 'orderUpdate'])->name('admin.orders.update');
    Route::post('/orders/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.orders.status');

    // 2. Product & Stock Management
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products.index');
    Route::get('/products/create', [AdminController::class, 'productCreate'])->name('admin.products.create');
    Route::post('/products/store', [AdminController::class, 'productStore'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'productEdit'])->name('admin.products.edit');
    Route::post('/products/{id}/update', [AdminController::class, 'productUpdate'])->name('admin.products.update');
    Route::post('/products/{id}/delete', [AdminController::class, 'productDelete'])->name('admin.products.delete');

    // 3. Category Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories.index');
    Route::post('/categories/store', [AdminController::class, 'categoryStore'])->name('admin.categories.store');
    Route::post('/categories/{id}/update', [AdminController::class, 'categoryUpdate'])->name('admin.categories.update');
    Route::post('/categories/{id}/delete', [AdminController::class, 'categoryDelete'])->name('admin.categories.delete');

    // 4. Customer CRM & Fraud Detection
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers.index');
});
