Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth');
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
});