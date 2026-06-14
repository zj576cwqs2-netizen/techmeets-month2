<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
//use App\Http\Controllers\PostController;
// ProductController may not exist yet in codebase; reference by string to avoid static analysis error
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;

// 基本的なルート（GETリクエストで / にアクセスしたら welcome ビューを返す）
Route::get('/', function () {
    return view('welcome');
});
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
//Route::resource('posts', PostController::class);
Route::resource('products', 'App\\Http\\Controllers\\ProductController');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('/events/{event}/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/events/{event}/reservations', [ReservationController::class, 'store'])->name('reservations.store');

Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');