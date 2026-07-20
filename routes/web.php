<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Landing: marketing page for guests, dashboard redirect for users.
Route::get('/', function () {
    if (! Auth::check()) {
        return view('landing', [
            'featured' => \App\Models\Product::where('is_featured', true)->take(3)->get(),
            'inspirations' => \App\Models\Inspiration::take(3)->get(),
        ]);
    }

    return redirect()->route(Auth::user()->isAdmin() ? 'admin.dashboard' : 'client.dashboard');
})->name('home');

// ----- Guest auth -----
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ----- Client area -----
Route::middleware(['auth', 'role:client'])->prefix('app')->name('client.')->group(function () {
    Route::get('/', [Client\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/projects', [Client\ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [Client\ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [Client\ProjectController::class, 'show'])->name('projects.show');
    Route::post('/projects/{project}/generate', [Client\ProjectController::class, 'generate'])->name('projects.generate');

    Route::get('/inspiration', [Client\InspirationController::class, 'index'])->name('inspiration');

    Route::get('/store', [Client\StoreController::class, 'index'])->name('store');
    Route::get('/store/category/{category}', [Client\StoreController::class, 'category'])->name('store.category');
    Route::get('/store/product/{product}', [Client\StoreController::class, 'show'])->name('store.show');

    Route::post('/favorites/toggle', [Client\FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites', [Client\FavoriteController::class, 'index'])->name('favorites');
    Route::post('/store/product/{product}/review', [Client\ReviewController::class, 'store'])->name('store.review');

    Route::post('/cart/add/{product}', [Client\CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [Client\CartController::class, 'index'])->name('cart');
    Route::post('/cart/update', [Client\CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/checkout', [Client\CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/orders', [Client\CartController::class, 'orders'])->name('orders');
    Route::get('/portfolio', [Client\PortfolioController::class, 'index'])->name('portfolio');
    Route::get('/about', [Client\AboutController::class, 'index'])->name('about');

    Route::get('/chat', [Client\ChatController::class, 'index'])->name('chat');
    Route::post('/chat', [Client\ChatController::class, 'store'])->name('chat.store');

    Route::get('/settings', [Client\SettingsController::class, 'edit'])->name('settings');
    Route::put('/settings', [Client\SettingsController::class, 'update'])->name('settings.update');
});

// ----- Admin area -----
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/clients', [Admin\ClientController::class, 'index'])->name('clients');
    Route::get('/requests', [Admin\RequestController::class, 'index'])->name('requests');
    Route::patch('/requests/{project}', [Admin\RequestController::class, 'update'])->name('requests.update');

    Route::get('/products', [Admin\ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [Admin\ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/categories', [Admin\CategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders');
    Route::patch('/orders/{order}', [Admin\OrderController::class, 'update'])->name('orders.update');

    Route::get('/settings', [Admin\DashboardController::class, 'settings'])->name('settings');
});
