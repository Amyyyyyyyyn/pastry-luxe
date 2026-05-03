<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/*
| Browsers request /favicon.ico by default. Without a real file, many show a generic tab
| icon even if <link rel="icon"> is set. Serve the same assets as the layout favicon chain.
*/
Route::get('/favicon.ico', function () {
    $usable = static fn (string $path): bool => is_file($path) && filesize($path) > 0;
    $candidates = [
        [public_path('favicon.ico'), 'image/x-icon'],
        [public_path('favicon.png'), 'image/png'],
        [public_path('brand-logo.png'), 'image/png'],
        [public_path('favicon.svg'), 'image/svg+xml'],
    ];
    foreach ($candidates as [$path, $mime]) {
        if ($usable($path)) {
            return response()->file($path, ['Content-Type' => $mime]);
        }
    }
    abort(404);
});

Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/catalogue', [ShopController::class, 'products'])->name('shop.products');
Route::get('/produit/{product:slug}', [ShopController::class, 'show'])->name('shop.product.show');

Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/ajouter', [CartController::class, 'add'])->name('cart.add');
Route::put('/panier/ligne/{line}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/panier/ligne/{line}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/commander', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/commander', [CheckoutController::class, 'place'])->middleware('throttle:orders')->name('checkout.place');
Route::get('/merci/{order}', [CheckoutController::class, 'thanks'])->name('checkout.thanks');

Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::post('/products', [AdminController::class, 'productStore'])->name('products.store');
    Route::patch('/products/{product}', [AdminController::class, 'productUpdate'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'productDestroy'])->name('products.destroy');
    Route::get('/commandes', [AdminController::class, 'orders'])->name('orders');
    Route::get('/commandes/{order}', [AdminController::class, 'orderShow'])->name('orders.show');
    Route::patch('/commandes/{order}', [AdminController::class, 'orderUpdate'])->name('orders.update');
});
