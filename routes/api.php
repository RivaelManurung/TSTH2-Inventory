<?php

// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\JenisBarangController;
use App\Http\Controllers\Master\RoleController;

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [LoginController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout']);
        Route::post('/refresh', [LoginController::class, 'refresh']);
        Route::post('/profile', [LoginController::class, 'profile']);
    });
});

// Protected routes with dynamic role checking
Route::middleware(['auth:api', 'dynamic.role'])->group(function () {
    // Gudang routes
    Route::controller(GudangController::class)->group(function () {
        Route::get('/gudang', 'index')->name('gudang.index');
        Route::post('/gudang', 'store')->name('gudang.store');
        Route::get('/gudang/{id}', 'show')->name('gudang.show');
        Route::put('/gudang/{id}', 'update')->name('gudang.update');
        Route::delete('/gudang/{id}', 'destroy')->name('gudang.destroy');
    });

    // Satuan routes
    Route::controller(SatuanController::class)->group(function () {
        Route::get('/satuan', 'show')->name('satuan.show');
        Route::post('/satuan', 'store')->name('satuan.store');
        Route::put('/satuan/{satuan}', 'update')->name('satuan.update');
        Route::delete('/satuan/{satuan}', 'destroy')->name('satuan.destroy');
    });

    // Jenis Barang routes
    Route::controller(JenisBarangController::class)->group(function () {
        Route::get('/jenisbarang', 'show')->name('jenisbarang.show');
        Route::post('/jenisbarang', 'store')->name('jenisbarang.store');
        Route::put('/jenisbarang/{jenisbarang}', 'update')->name('jenisbarang.update');
        Route::delete('/jenisbarang/{jenisbarang}', 'destroy')->name('jenisbarang.destroy');
    });

    // Role management routes
    Route::controller(RoleController::class)->group(function () {
        Route::get('/roles', 'index')->name('roles.index');
        Route::post('/roles', 'store')->name('roles.store');
        Route::get('/roles/{id}', 'show')->name('roles.show');
        Route::put('/roles/{id}', 'update')->name('roles.update');
        Route::delete('/roles/{id}', 'destroy')->name('roles.destroy');
        
        // Additional role management endpoints
        Route::post('/roles/{id}/permissions', 'assignPermissions')->name('roles.permissions.assign');
        Route::get('/roles/{id}/permissions', 'getPermissions')->name('roles.permissions.get');
        Route::get('/permissions', 'getAllPermissions')->name('permissions.all');
    });
});