<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\JobNumberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::middleware(['auth', 'userLevel:0'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        // JobNumber
        Route::get('/Admin/JobNumber/List', [JobNumberController::class, 'index'])->name('index_jn_admin');
        Route::get('/Admin/JobNumber/Create', [JobNumberController::class, 'create'])->name('create_jn_admin');
        Route::post('/Admin/JobNumber/Store', [JobNumberController::class, 'store'])->name('store_jn_admin');
        Route::get('/Admin/JobNumber/Edit/{id}', [JobNumberController::class, 'edit'])->name('edit_jn_admin');
        Route::POST('/Admin/JobNumber/Update/{id}', [JobNumberController::class, 'update'])->name('update_jn_admin');
        Route::delete('/Admin/JobNumber/Destroy/{id}', [JobNumberController::class, 'destroy'])->name('destroy_jn_admin');
        // Client
        Route::get('/Admin/Client/List', [ClientController::class, 'index'])->name('index_client_admin');
        Route::get('/Admin/Client/Create', [ClientController::class, 'create'])->name('create_client_admin');
        Route::post('/Admin/Client/Store', [ClientController::class, 'store'])->name('store_client_admin');
        Route::get('/Admin/Client/Edit/{id}', [ClientController::class, 'edit'])->name('edit_client_admin');
        Route::POST('/Admin/Client/Update/{id}', [ClientController::class, 'update'])->name('update_client_admin');
        Route::delete('/Admin/Client/Destroy/{id}', [ClientController::class, 'destroy'])->name('destroy_client_admin');
    });
    Route::middleware(['auth', 'userLevel:1'])->group(function () {
    });
    // Route::middleware(['auth', 'userLevel:2'])->group(function () {
    //     echo json_encode("User Level = 2");
    // });
    // Route::middleware(['auth', 'userLevel:3'])->group(function () {
    //     echo json_encode("User Level = 3");
    // });
});
