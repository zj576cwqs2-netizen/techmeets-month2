<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

// 基本的なルート（GETリクエストで / にアクセスしたら welcome ビューを返す）
Route::get('/', function () {
    return view('welcome');
});
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::resource('posts', PostController::class);