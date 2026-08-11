<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\StripeCheckoutController;
use App\Http\Controllers\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);

Route::get('/checkout', [StripeCheckoutController::class, 'create'])->name('checkout.create');
Route::get('/checkout/success', function () {
    return view('checkout.success');
})->name('checkout.success');
Route::get('/checkout/cancel', function () {
    return view('checkout.cancel');
})->name('checkout.cancel');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');