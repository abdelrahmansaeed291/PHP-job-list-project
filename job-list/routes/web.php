<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/job-listings', [JobListingController::class, 'store']); // Create a job listing
    Route::put('/job-listings/{id}', [JobListingController::class, 'update']); // Update a job listing
    Route::delete('/job-listings/{id}', [JobListingController::class, 'destroy']); // Delete a job listing
});

