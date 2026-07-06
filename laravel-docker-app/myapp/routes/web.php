<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TaskController;

require __DIR__.'/auth.php';

// 基本的なルート（GETリクエストで / にアクセスしたら welcome ビューを返す）
Route::get('/', [PostController::class, 'index']);
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
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::resource('posts', 'App\\Http\\Controllers\\PostController');

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::get('/dashboard', function () {
    return view('posts.dashboard');
});

Route::get('/vue-test', function () {
    return view('vue-test');
});
});