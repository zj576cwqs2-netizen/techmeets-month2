<?php

require __DIR__.'/auth.php';

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/posts', 'App\\Http\\Controllers\\PostController@index');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', function () {
    return view('checkout.cancel');
})->name('checkout.cancel');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});
Route::get('/check-file', fn () => 'このファイルが読み込まれています');
Route::get('/check-file', fn () => 'このファイルが読み込まれています');

use App\Http\Controllers\StripeWebhookController;

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);
Route::post('/posts', [PostController::class, 'store']);
