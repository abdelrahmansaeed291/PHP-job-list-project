<?php


use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:api')->group(function () {
    Route::post('/job-listings', [JobListingController::class, 'store']);
    Route::get('/job-listings', [JobListingController::class, 'index']);
    Route::put('/job-listings/{id}', [JobListingController::class, 'update']);
    Route::delete('/job-listings/{id}', [JobListingController::class, 'destroy']);
});
