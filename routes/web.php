<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\EPurchaseController;
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
        Route::get('/List_JN', [JobNumberController::class, 'refresh_jn'])->name('refresh_jn_admin');
        // Client
        Route::get('/Admin/Client/List', [ClientController::class, 'index'])->name('index_client_admin');
        Route::get('/Admin/Client/Create', [ClientController::class, 'create'])->name('create_client_admin');
        Route::post('/Admin/Client/Store', [ClientController::class, 'store'])->name('store_client_admin');
        Route::get('/Admin/Client/Edit/{id}', [ClientController::class, 'edit'])->name('edit_client_admin');
        Route::POST('/Admin/Client/Update/{id}', [ClientController::class, 'update'])->name('update_client_admin');
        Route::delete('/Admin/Client/Destroy/{id}', [ClientController::class, 'destroy'])->name('destroy_client_admin');
        // Purchase Request
        Route::get('/Admin/EPurchase/PR/List', [EPurchaseController::class, 'index_pr'])->name('index_pr_admin');
        Route::get('/Admin/EPurchase/PR/Create', [EPurchaseController::class, 'create_pr'])->name('create_pr_admin');
        Route::post('/Admin/EPurchase/PR/Store', [EPurchaseController::class, 'store_pr'])->name('store_pr_admin');
        Route::get('/Admin/EPurchase/PR/Edit/{id}', [EPurchaseController::class, 'edit_pr'])->name('edit_pr_admin');
        Route::POST('/Admin/EPurchase/PR/Update/{id}', [EPurchaseController::class, 'update_pr'])->name('update_pr_admin');
        Route::delete('/Admin/EPurchase/PR/Destroy/{id}', [EPurchaseController::class, 'destroy_pr'])->name('destroy_pr_admin');
        // Purchase Order
        Route::get('/Admin/EPurchase/PO/List', [EPurchaseController::class, 'index_po'])->name('index_po_admin');
        Route::get('/Admin/EPurchase/PO/Create', [EPurchaseController::class, 'create_po'])->name('create_po_admin');
        Route::post('/Admin/EPurchase/PO/Store', [EPurchaseController::class, 'store_po'])->name('store_po_admin');
        Route::get('/Admin/EPurchase/PO/Edit/{id}', [EPurchaseController::class, 'edit_po'])->name('edit_po_admin');
        Route::POST('/Admin/EPurchase/PO/Update/{id}', [EPurchaseController::class, 'update_po'])->name('update_po_admin');
        Route::delete('/Admin/EPurchase/PO/Destroy/{id}', [EPurchaseController::class, 'destroy_po'])->name('destroy_po_admin');
        // Vendor
        Route::get('/Admin/EPurchase/Vendor/List', [EPurchaseController::class, 'index_vendor'])->name('index_vendor_admin');
        Route::get('/Admin/EPurchase/Vendor/Create', [EPurchaseController::class, 'create_vendor'])->name('create_vendor_admin');
        Route::post('/Admin/EPurchase/Vendor/Store', [EPurchaseController::class, 'store_vendor'])->name('store_vendor_admin');
        Route::get('/Admin/EPurchase/Vendor/Edit/{id}', [EPurchaseController::class, 'edit_vendor'])->name('edit_vendor_admin');
        Route::POST('/Admin/EPurchase/Vendor/Update/{id}', [EPurchaseController::class, 'update_vendor'])->name('update_vendor_admin');
        Route::delete('/Admin/EPurchase/Vendor/Destroy/{id}', [EPurchaseController::class, 'destroy_vendor'])->name('destroy_vendor_admin');
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
