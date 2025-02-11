<?php

// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\JenisBarangController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\Master\AksesController;

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

    // Profile
    Route::get('/admin/profile/{user}', [UserController::class, 'profile']);
    Route::post('/admin/updatePassword/{user}', [UserController::class, 'updatePassword']);
    Route::post('/admin/updateProfile/{user}', [UserController::class, 'updateProfile']);
    // Route::get('/admin/appreance/', [AppreanceController::class, 'index']);
    // Route::post('/admin/appreance/{setting}', [AppreanceController::class, 'update']);

    // Gudang routes
    Route::middleware(['checkRoleUser:/gudang,submenu'])->group(function () {
        Route::controller(GudangController::class)->group(function () {
            Route::get('/gudang', 'index')->name('gudang.index');
            Route::post('/gudang', 'store')->name('gudang.store');
            Route::get('/gudang/{id}', 'show')->name('gudang.show');
            Route::put('/gudang/{id}', 'update')->name('gudang.update');
            Route::delete('/gudang/{id}', 'destroy')->name('gudang.destroy');
        });
    });

    // Satuan routes
    Route::middleware(['checkRoleUser:/satuan,submenu'])->group(function () {
        Route::controller(SatuanController::class)->group(function () {
            Route::get('/satuan', 'index')->name('satuan.index');
            Route::get('/satuan/{id}', 'show')->name('satuan.show');
            Route::post('/satuan', 'store')->name('satuan.store');
            Route::put('/satuan/{satuan}', 'update')->name('satuan.update');
            Route::delete('/satuan/{satuan}', 'destroy')->name('satuan.destroy');
        });
    });

    // Jenis Barang routes
    Route::middleware(['checkRoleUser:/jenisbarang,submenu'])->group(function () {
        Route::controller(JenisBarangController::class)->group(function () {
            Route::get('/jenisbarang', 'show')->name('jenisbarang.show');
            Route::post('/jenisbarang', 'store')->name('jenisbarang.store');
            Route::put('/jenisbarang/{jenisbarang}', 'update')->name('jenisbarang.update');
            Route::delete('/jenisbarang/{jenisbarang}', 'destroy')->name('jenisbarang.destroy');
        });
    });

    // Role management routes
    Route::middleware(['checkRoleUser:/roles,submenu'])->group(function () {
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

    // Akses routes
    // Route::middleware(['checkRoleUser:akses,submenu'])->group(function () {
    //     Route::controller(AksesController::class)->group(function () {
    //         Route::get('/akses/{role_id}', 'getAksesByRole')->name('akses.get'); // Ambil akses berdasarkan role
    //         Route::post('/akses', 'addAkses')->name('akses.addAkses'); // Tambah akses untuk role
    //         Route::delete('/akses', 'removeAkses')->name('akses.remove'); // Hapus akses tertentu untuk role
    //         Route::post('/akses/{role_id}/set-all', 'setAllAkses')->name('akses.set_all'); // Berikan semua akses ke role
    //         Route::delete('/akses/{role_id}/unset-all', 'unsetAllAkses')->name('akses.unset_all'); // Hapus semua akses dari role
    //     });
    // });
    Route::middleware(['checkRoleUser:1,othermenu'])->group(function () {

        // Route::middleware(['checkRoleUser:2,othermenu'])->group(function () {
        //     // Menu
        //     Route::resource('/admin/menu', \App\Http\Controllers\Master\MenuController::class);
        //     Route::post('/admin/menu/hapus', [MenuController::class, 'hapus']);
        //     Route::get('/admin/menu/sortup/{sort}', [MenuController::class, 'sortup']);
        //     Route::get('/admin/menu/sortdown/{sort}', [MenuController::class, 'sortdown']);
        // });

        Route::middleware(['checkRoleUser:3,othermenu'])->group(function () {
            // Role
            Route::resource('/admin/role', RoleController::class);
            Route::get('/admin/role/show/', [RoleController::class, 'show'])->name('role.getrole');
            Route::post('/admin/role/hapus', [RoleController::class, 'hapus']);
        });

        Route::middleware(['checkRoleUser:4,othermenu'])->group(function () {
            // List User
            Route::controller(UserController::class)->group(function () {
                Route::resource('/admin/user', UserController::class);
                Route::get('/admin/user/show/', [UserController::class, 'show'])->name('user.getuser');
                Route::post('/admin/user/hapus', [UserController::class, 'destroy']);
            });
        });

        Route::middleware(['checkRoleUser:5,othermenu'])->group(function () {
            Route::controller(AksesController::class)->group(function () {
                Route::get('/akses/{role_id}', 'getAksesByRole')->name('akses.get'); // Ambil akses berdasarkan role
                Route::post('/akses', 'addAkses')->name('akses.addAkses'); // Tambah akses untuk role
                Route::delete('/akses', 'removeAkses')->name('akses.remove'); // Hapus akses tertentu untuk role
                Route::post('/akses/{role_id}/set-all', 'setAllAkses')->name('akses.set_all'); // Berikan semua akses ke role
                Route::delete('/akses/{role_id}/unset-all', 'unsetAllAkses')->name('akses.unset_all'); // Hapus semua akses dari role
            });
            // Route::middleware(['checkRoleUser:6,othermenu'])->group(function () {
            //     // Web
            //     Route::resource('/admin/web', \App\Http\Controllers\Master\WebController::class);
            // });
        });
    });


    // // Protected routes with dynamic role checking
    // Route::middleware(['auth:api', 'dynamic.role'])->group(function () {
    //     // Gudang routes
    //     Route::controller(GudangController::class)->group(function () {
    //         Route::get('/gudang', 'index')->name('gudang.index');
    //         Route::post('/gudang', 'store')->name('gudang.store');
    //         Route::get('/gudang/{id}', 'show')->name('gudang.show');
    //         Route::put('/gudang/{id}', 'update')->name('gudang.update');
    //         Route::delete('/gudang/{id}', 'destroy')->name('gudang.destroy');
    //     });

    //     // Satuan routes
    //     Route::controller(SatuanController::class)->group(function () {
    //         Route::get('/satuan', 'show')->name('satuan.show');
    //         Route::post('/satuan', 'store')->name('satuan.store');
    //         Route::put('/satuan/{satuan}', 'update')->name('satuan.update');
    //         Route::delete('/satuan/{satuan}', 'destroy')->name('satuan.destroy');
    //     });

    //     // Jenis Barang routes
    //     Route::controller(JenisBarangController::class)->group(function () {
    //         Route::get('/jenisbarang', 'show')->name('jenisbarang.show');
    //         Route::post('/jenisbarang', 'store')->name('jenisbarang.store');
    //         Route::put('/jenisbarang/{jenisbarang}', 'update')->name('jenisbarang.update');
    //         Route::delete('/jenisbarang/{jenisbarang}', 'destroy')->name('jenisbarang.destroy');
    //     });

    //     // Role management routes
    //     Route::controller(RoleController::class)->group(function () {
    //         Route::get('/roles', 'index')->name('roles.index');
    //         Route::post('/roles', 'store')->name('roles.store');
    //         Route::get('/roles/{id}', 'show')->name('roles.show');
    //         Route::put('/roles/{id}', 'update')->name('roles.update');
    //         Route::delete('/roles/{id}', 'destroy')->name('roles.destroy');

    //         // Additional role management endpoints
    //         Route::post('/roles/{id}/permissions', 'assignPermissions')->name('roles.permissions.assign');
    //         Route::get('/roles/{id}/permissions', 'getPermissions')->name('roles.permissions.get');
    //         Route::get('/permissions', 'getAllPermissions')->name('permissions.all');
    //     });
    //     Route::controller(AksesController::class)->group(function () {
    //         Route::get('/akses/{role_id}', 'getAksesByRole')->name('akses.get'); // Ambil akses berdasarkan role
    //         Route::post('/akses', 'addAkses')->name('akses.addAkses'); // Tambah akses untuk role
    //         Route::delete('/akses', 'removeAkses')->name('akses.remove'); // Hapus akses tertentu untuk role
    //         Route::post('/akses/{role_id}/set-all', 'setAllAkses')->name('akses.set_all'); // Berikan semua akses ke role
    //         Route::delete('/akses/{role_id}/unset-all', 'unsetAllAkses')->name('akses.unset_all'); // Hapus semua akses dari role
    //     });
    // });
});
// Route::middleware(['auth:api'])->group(function () {
//     Route::controller(GudangController::class)->group(function () {
//         Route::get('/gudang', 'index')->name('gudang.index');   
//         Route::post('/gudang', 'store')->name('gudang.store');
//         Route::get('/gudang/{id}', 'show')->name('gudang.show');
//         Route::put('/gudang/{id}', 'update')->name('gudang.update');
//         Route::delete('/gudang/{id}', 'destroy')->name('gudang.destroy');
//     });
// });
