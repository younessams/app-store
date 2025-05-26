<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminOfferController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::middleware('auth')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});

// For translate
Route::get('/lang/{locale}', function($locale) {
    session(['locale' => $locale]);
    App::setLocale($locale);
    return redirect()->back();
});

// Route::get('/settings', fn() => Inertia::render('Admin/Settings'))->name('settings');

Route::middleware([AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('admin/Dashboard'))->name('dashboard');
    
    // Product Routes
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('list');
        Route::get('/create', [AdminProductController::class, 'create'])->name('create');
        Route::post('/', [AdminProductController::class, 'store'])->name('store');
        Route::get('/{slug}', [AdminProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [AdminProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('destroy');
    });

    //Category Routes
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('list');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // Offers resourses routes
    Route::resource('offers', AdminOfferController::class);
});

Route::middleware('guest')->group(function(){
    Route::get('/login',fn() => Inertia::render('auth/Login'))->name('login');
    Route::get('/register',fn() => Inertia::render('auth/Register'))->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::prefix('products')->name('products.')->group(function(){
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/product/{slug}', [ProductController::class, 'show'])->name('show');
});

Route::prefix('cart')->name('cart.')->group(function(){
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/', [CartController::class, 'addToCart'])->name('addToCart');
    Route::delete('/{cart}', [CartController::class, 'destroy'])->name('destroy');
    Route::patch('/{cart}', [CartController::class, 'update'])->name('update');
});

Route::prefix('checkout')->name('checkout.')->group(function(){
    Route::get('/thanks', [CheckoutController::class, 'thanks'])->name('thanks');
    Route::post('', [CheckoutController::class, 'store'])->name('store');
});

Route::prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/fetch', [WishlistController::class, 'fetch'])->name('fetch');
    // Route::get('/', [WishlistController::class, 'index'])->name('index');
    // Route::post('/', [WishlistController::class, 'store'])->name('store');
    Route::delete('/{productId}', [WishlistController::class, 'destroy'])->name('destroy');
    Route::post('/toggle', [WishlistController::class, 'toggle'])->name('toggle'); // ✅ toggle
});

Route::prefix('contact')->group(function(){
    Route::get('/', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/', [ContactController::class, 'store'])->name('contact.store');
    Route::post('/subscribe', [ContactController::class, 'subscribe'])->name('contact.subscribe');
});

Route::prefix('categories')->group(function(){
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/{slug}', [CategoryController::class, 'show'])->name('categories.show');
});

Route::get('/offers/{slug}', [OfferController::class, 'show'])->name('offers.show');

Route::get('/faq', fn ()=> Inertia::render('FAQ/Index') );

Route::get('/shipping', fn () => Inertia::render('Static/ShippingPolicy'))->name('shipping.policy');

