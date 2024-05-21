<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\EPurchaseController;
use App\Http\Controllers\Admin\JobNumberController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Manager\EPurchaseManagerController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::controller(LoginController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        // 
        Route::middleware(['auth', 'userLevel:0'])->group(function () {

            // JobNumber
            Route::get('/Admin/JobNumber/List', [JobNumberController::class, 'index'])->name('index_jn_admin');
            Route::get('/Admin/JobNumber/List/Old', [JobNumberController::class, 'index_old'])->name('index_jn_old_admin');
            Route::get('/Admin/JobNumber/Show/JN_OLD/{id}', [JobNumberController::class, 'show_jn_old_admin'])->name('show_jn_old_admin');
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
            Route::POST('/Admin/EPurchase/PR/Store', [EPurchaseController::class, 'store_pr'])->name('store_pr_admin');
            Route::get('/Admin/EPurchase/PR/Edit/{id}', [EPurchaseController::class, 'edit_pr'])->name('edit_pr_admin');
            Route::POST('/Admin/EPurchase/PR/Update/{id}', [EPurchaseController::class, 'update_pr'])->name('update_pr_admin');
            Route::delete('/Admin/EPurchase/PR/Destroy/{id}', [EPurchaseController::class, 'destroy_pr'])->name('destroy_pr_admin');
            // Purchase Order
            Route::get('/Admin/EPurchase/PO/List', [EPurchaseController::class, 'index_po'])->name('index_po_admin');
            Route::get('/Admin/EPurchase/PO/Create', [EPurchaseController::class, 'create_po'])->name('create_po_admin');
            Route::post('/Admin/EPurchase/PO/Store', [EPurchaseController::class, 'store_po'])->name('store_po_admin');
            Route::post('/Admin/EPurchase/PO/Price/Store', [EPurchaseController::class, 'store_price'])->name('store_price_admin');
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


            // Show Modal Data
            Route::get('show_modal_pr_admin/{id}', [EPurchaseController::class, 'show_modal_pr_admin'])->name('show_modal_pr_admin');
            Route::get('show_modal_price_admin/{id}', [EPurchaseController::class, 'show_modal_price_admin'])->name('show_modal_price_admin');
        });
        Route::middleware(['auth', 'userLevel:2'])->group(function () {

            // JobNumber
            Route::get('/Manager/JobNumber/List', [ManagerController::class, 'index_jn'])->name('index_jn_manager');
            Route::get('/Manager/JobNumber/List/Old', [ManagerController::class, 'index_old_jn'])->name('index_jn_old_manager');
            Route::get('/Manager/JobNumber/Show/JN_OLD/{id}', [ManagerController::class, 'show_jn_old_manager'])->name('show_jn_old_manager');
            Route::get('/Manager/JobNumber/Create', [ManagerController::class, 'create'])->name('create_jn_manager');
            Route::post('/Manager/JobNumber/Store', [ManagerController::class, 'store'])->name('store_jn_manager');
            Route::get('/Manager/JobNumber/Edit/{id}', [ManagerController::class, 'edit'])->name('edit_jn_manager');
            Route::POST('/Manager/JobNumber/Update/{id}', [ManagerController::class, 'update'])->name('update_jn_manager');
            Route::delete('/Manager/JobNumber/Destroy/{id}', [ManagerController::class, 'destroy'])->name('destroy_jn_manager');
            Route::get('/Manager_List_JN', [ManagerController::class, 'refresh_jn'])->name('refresh_jn_manager');
            // Client
            Route::get('/Manager_List_JN/Client/List', [ManagerController::class, 'index_client'])->name('index_client_manager');
            Route::get('/Manager_List_JN/Client/Show/{id}', [ManagerController::class, 'show_client'])->name('show_client_manager');
            Route::post('/Manager_List_JN/Client/Store', [ManagerController::class, 'store_client'])->name('store_client_manager');
            // Purchase Request
            Route::get('/Manager/EPurchase/PR/List', [EPurchaseManagerController::class, 'index'])->name('index_pr_manager');
            Route::POST('/Manager/EPurchase/PR/Approve', [EPurchaseManagerController::class, 'approve_pr_manager'])->name('approve_pr_manager');
            Route::POST('/Manager/EPurchase/PR/Reject', [EPurchaseManagerController::class, 'reject_pr_manager'])->name('reject_pr_manager');
            // Purchase Order
            Route::get('/Manager/EPurchase/PO/List', [EPurchaseController::class, 'index_po'])->name('index_po_manager');
            Route::get('/Manager/EPurchase/PO/Create', [EPurchaseController::class, 'create_po'])->name('create_po_manager');
            Route::post('/Manager/EPurchase/PO/Store', [EPurchaseController::class, 'store_po'])->name('store_po_manager');
            Route::get('/Manager/EPurchase/PO/Edit/{id}', [EPurchaseController::class, 'edit_po'])->name('edit_po_manager');
            Route::POST('/Manager/EPurchase/PO/Update/{id}', [EPurchaseController::class, 'update_po'])->name('update_po_manager');
            Route::delete('/Manager/EPurchase/PO/Destroy/{id}', [EPurchaseController::class, 'destroy_po'])->name('destroy_po_manager');
            // Vendor
            Route::get('/Admin/EPurchase/Vendor/List', [EPurchaseController::class, 'index_vendor'])->name('index_vendor_admin');
            Route::get('/Admin/EPurchase/Vendor/Create', [EPurchaseController::class, 'create_vendor'])->name('create_vendor_admin');
            Route::post('/Admin/EPurchase/Vendor/Store', [EPurchaseController::class, 'store_vendor'])->name('store_vendor_admin');
            Route::get('/Admin/EPurchase/Vendor/Edit/{id}', [EPurchaseController::class, 'edit_vendor'])->name('edit_vendor_admin');
            Route::POST('/Admin/EPurchase/Vendor/Update/{id}', [EPurchaseController::class, 'update_vendor'])->name('update_vendor_admin');
            Route::delete('/Admin/EPurchase/Vendor/Destroy/{id}', [EPurchaseController::class, 'destroy_vendor'])->name('destroy_vendor_admin');
            // Report e-Purchase
            // 
            // Show Modal Data
            Route::get('show_modal_pr_manager/{id}', [EPurchaseManagerController::class, 'show_modal_pr_manager'])->name('show_modal_pr_manager');
        });
        // Route::middleware(['auth', 'userLevel:2'])->group(function () {
        //     echo json_encode("User Level = 2");
        // });
        // Route::middleware(['auth', 'userLevel:3'])->group(function () {
        //     echo json_encode("User Level = 3");
        // });
    });
});
