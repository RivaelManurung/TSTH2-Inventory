<?php

// use App\Http\Controllers\Admin\LoginController;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\GudangController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [LoginController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [LoginController::class, 'refresh'])->middleware('auth:api');
    Route::post('/profile', [LoginController::class, 'profile'])->middleware('auth:api');
});

// Add Gudang routes with API middleware and authentication
Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'gudang'
], function ($router) {
    Route::get('/', [GudangController::class, 'index']);
    Route::post('/', [GudangController::class, 'store']);
    Route::get('/{id}', [GudangController::class, 'show']);
    Route::put('/{id}', [GudangController::class, 'update']);
    Route::delete('/{id}', [GudangController::class, 'destroy']);
});