<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\ATKController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\OldData\OldJNController;
use App\Http\Controllers\HRGA\InventoryController;
use App\Http\Controllers\Admin\EPurchaseController;
use App\Http\Controllers\Admin\JobNumberController;
use App\Http\Controllers\Admin\LegalitasController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\HRGA\HREpurchaseController;
use App\Http\Controllers\HRGA\HRJobNumberController;
use App\Http\Controllers\Admin\LetterNumberController;
use App\Http\Controllers\HRGA\HRGAController;
use App\Http\Controllers\OldData\OldLetterNumberController;
use App\Http\Controllers\Manager\EPurchaseManagerController;
use App\Http\Controllers\Users\UsersController as UsersUsersController;
use App\Http\Controllers\Users\EPurchaseController as UsersEPurchaseController;
use App\Http\Controllers\LetterNumberController as ControllersLetterNumberController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get('/OldData/JobNumber/2018', [OldJNController::class, 'index_jn_2018'])->name('index_jn_2018');
    Route::get('/OldData/JobNumber/2019', [OldJNController::class, 'index_jn_2019'])->name('index_jn_2019');
    Route::get('/OldData/JobNumber/2020', [OldJNController::class, 'index_jn_2020'])->name('index_jn_2020');
    Route::get('/OldData/JobNumber/2021', [OldJNController::class, 'index_jn_2021'])->name('index_jn_2021');
    Route::get('/OldData/JobNumber/2022', [OldJNController::class, 'index_jn_2022'])->name('index_jn_2022');
    Route::get('/OldData/JobNumber/2023', [OldJNController::class, 'index_jn_2023'])->name('index_jn_2023');
    Route::get('/OldData/JobNumber/2024', [OldJNController::class, 'index_jn_2024'])->name('index_jn_2024');

    Route::get('OldData/LetterNumber/2018', [OldLetterNumberController::class, 'index_letter_2018'])->name('index_letter_2018');
    Route::get('OldData/LetterNumber/2019', [OldLetterNumberController::class, 'index_letter_2019'])->name('index_letter_2019');
    Route::get('OldData/LetterNumber/2020', [OldLetterNumberController::class, 'index_letter_2020'])->name('index_letter_2020');
    Route::get('OldData/LetterNumber/2021', [OldLetterNumberController::class, 'index_letter_2021'])->name('index_letter_2021');
    Route::get('OldData/LetterNumber/2022', [OldLetterNumberController::class, 'index_letter_2022'])->name('index_letter_2022');
    Route::get('OldData/LetterNumber/2023', [OldLetterNumberController::class, 'index_letter_2023'])->name('index_letter_2023');
    Route::get('OldData/LetterNumber/2024', [OldLetterNumberController::class, 'index_letter_2024'])->name('index_letter_2024');


    Route::get('LetterNumber/Index', [ControllersLetterNumberController::class, 'index_letter_number'])->name('index_letter_number');
    Route::post('LetterNumber/Store', [ControllersLetterNumberController::class, 'store_letter_number'])->name('store_letter_number');
    Route::get('LetterNumber/Store/Create', [ControllersLetterNumberController::class, 'show_modal_create_letter_number'])->name('show_modal_create_letter_number');
    Route::get('/refresh/number', [ControllersLetterNumberController::class, 'refresh_last_number'])->name('refresh_last_number');

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
            Route::get('/List_JN', [JobNumberController::class, 'refresh_jn_admin'])->name('refresh_jn_admin');
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
            Route::get('/refresh/pr', [EPurchaseController::class, 'refresh_pr'])->name('refresh_pr');
            Route::get('/Admin/Epurchase/PR/OLD', [EPurchaseController::class, 'index_old_pr'])->name('index_old_pr');
            // Purchase Order
            Route::get('/Admin/EPurchase/PO/List', [EPurchaseController::class, 'index_po'])->name('index_po_admin');
            Route::get('/Admin/EPurchase/PO/Create', [EPurchaseController::class, 'create_po'])->name('create_po_admin');
            Route::post('/Admin/EPurchase/PO/Store', [EPurchaseController::class, 'store_po'])->name('store_po_admin');
            // Route::post('/Admin/EPurchase/PO/Store', [EPurchaseController::class, 'store_po_2'])->name('store_po_admin');
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
            // ATK
            Route::get('/Admin/ATK/Master/List', [ATKController::class, 'index'])->name('index_atk_master');
            Route::post('/Admin/ATK/Master/Store', [ATKController::class, 'store'])->name('store_atk_master');
            Route::get('/Admin/ATK/Master/Update', [ATKController::class, 'update'])->name('update_atk_master');
            Route::get('/Admin/ATK/Master/Create', [ATKController::class, 'create'])->name('show_modal_create_atk');

            Route::get('/Admin/ATK/In', [ATKController::class, 'index_atk_in'])->name('index_atk_in');
            Route::post('/Admin/ATK/In/Store', [ATKController::class, 'store_atk_in'])->name('store_atk_in');

            // Print e-Purchase
            Route::post('/Admin/EPurchase/PR/Print/', [EPurchaseController::class, 'print_pr_admin'])->name('print_pr_admin');
            Route::post('/Admin/EPurchase/PO/Print/', [EPurchaseController::class, 'print_po_admin'])->name('print_po_admin');
            // Show Modal Data
            Route::get('show_modal_pr_admin/{id}', [EPurchaseController::class, 'show_modal_pr_admin'])->name('show_modal_pr_admin');
            Route::get('show_modal_price_admin/{id}', [EPurchaseController::class, 'show_modal_price_admin'])->name('show_modal_price_admin');
            Route::get('show_modal_po_admin/{id}', [EPurchaseController::class, 'show_modal_po_admin'])->name('show_modal_po_admin');
            Route::get('show_modal_create_po_admin/{id}', [EPurchaseController::class, 'show_modal_create_po_admin'])->name('show_modal_create_po_admin');
            // Report 
            Route::get('/Admin/EPurchase/Search', [EPurchaseController::class, 'search_epurchase_admin'])->name('search_epurchase_admin');
            Route::post('/Admin/EPurchase/Search/Submit', [EPurchaseController::class, 'search_epurchase_admin_result'])->name('search_epurchase_admin_result');
            Route::get('/Admin/EPurchase/Search/Print/PR/{id}', [EPurchaseController::class, 'print_pr_epurchase_admin'])->name('print_pr_epurchase_admin');
            Route::get('/Admin/EPurchase/Search/Print/PO/{id}', [EPurchaseController::class, 'print_po_epurchase_admin'])->name('print_po_epurchase_admin');

            // Office Asset
            Route::get('/Admin/Asset/Office/Asset', [AssetController::class, 'index_office_asset'])->name('index_office_asset');
            Route::get('/Admin/Asset/Device/Master', [AssetController::class, 'index_device_master'])->name('index_device_master');
            Route::post('/Admin/Asset/Device/Master/Store', [AssetController::class, 'store_device_master'])->name('store_device_master');
            Route::post('/Admin/Asset/Office/Store', [AssetController::class, 'store_office_asset'])->name('store_office_asset');
            Route::post('/Admin/Asset/Office/QRCode', [AssetController::class, 'QR_Code_Generate'])->name('QR_Code_Generate');
            Route::get('/Admin/Asset/Office/QR', [AssetController::class, 'test_qr'])->name('test_qr');

            // Legalitas
            Route::get('/Admin/Legalitas/Office', [LegalitasController::class, 'index'])->name('index_office_legalitas');
            Route::post('/Admin/Legalitas/Office/Store', [LegalitasController::class, 'store'])->name('store_office_legalitas');
            Route::post('/Admin/Legalitas/Office/Update', [LegalitasController::class, 'update'])->name('update_office_legalitas');
            Route::get('/Admin/Legalitas/Office/Edit/{id}', [LegalitasController::class, 'edit'])->name('edit_office_legalitas');

            // Letter Number
            // Route::get('/Admin/LetterNumber', [LetterNumberController::class, 'index'])->name('index_letter_number');
            // Route::post('/Admin/LetterNumber/Store', [LetterNumberController::class, 'store'])->name('store_letter_number');
            // Route::get('/Admin/LetterNumber/Store/Create', [LetterNumberController::class, 'show'])->name('show_modal_create_letter_number');
            // Route::get('/refresh/number', [LetterNumberController::class, 'refresh_last_number'])->name('refresh_last_number');

            // User Management
            Route::get('/Admin/Users', [UsersController::class, 'index'])->name('index_users');
            Route::POST('/Admin/Users/Store', [UsersController::class, 'store'])->name('store_users');
            Route::get('/Admin/Users/Show/{id}', [UsersController::class, 'show'])->name('show_modal_users');
            Route::get('/Admin/Users/Edit/{id}', [UsersController::class, 'edit'])->name('edit_users');
            Route::post('/Admin/Users/Update', [UsersController::class, 'update'])->name('update_users');
            Route::delete('/Admin/Users/Delete/{id}', [UsersController::class, 'destroy'])->name('destroy_users');
            Route::post('/Admin/Users/Update/Status/{id}', [UsersController::class, 'update_status_users'])->name('update_status_users');
            Route::get('/Admin/Users/SendEmail/{id}', [UsersController::class, 'sendEmailUsersInformation'])->name('sendEmailUsersInformation');

            // Adds on
            Route::get('/data/json', [EPurchaseController::class, 'get_old_pr'])->name('get_old_pr');
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
            Route::POST('/Manager/EPurchase/PR/Approve_CheckBox', [EPurchaseManagerController::class, 'approve_pr_manager_checkbox'])->name('approve_pr_manager_checkbox');
            Route::POST('/Manager/EPurchase/PR/Approve', [EPurchaseManagerController::class, 'approve_pr_manager'])->name('approve_pr_manager');
            Route::POST('/Manager/EPurchase/PR/Reject', [EPurchaseManagerController::class, 'reject_pr_manager'])->name('reject_pr_manager');
            // Purchase Order
            Route::get('/Manager/EPurchase/PO/List', [EPurchaseManagerController::class, 'index_po'])->name('index_po_manager');
            Route::POST('/Manager/EPurchase/PO/Approve', [EPurchaseManagerController::class, 'approve_po_manager'])->name('approve_po_manager');
            // // Vendor
            // Route::get('/Admin/EPurchase/Vendor/List', [EPurchaseController::class, 'index_vendor'])->name('index_vendor_admin');
            // Route::get('/Admin/EPurchase/Vendor/Create', [EPurchaseController::class, 'create_vendor'])->name('create_vendor_admin');
            // Route::post('/Admin/EPurchase/Vendor/Store', [EPurchaseController::class, 'store_vendor'])->name('store_vendor_admin');
            // Route::get('/Admin/EPurchase/Vendor/Edit/{id}', [EPurchaseController::class, 'edit_vendor'])->name('edit_vendor_admin');
            // Route::POST('/Admin/EPurchase/Vendor/Update/{id}', [EPurchaseController::class, 'update_vendor'])->name('update_vendor_admin');
            // Route::delete('/Admin/EPurchase/Vendor/Destroy/{id}', [EPurchaseController::class, 'destroy_vendor'])->name('destroy_vendor_admin');
            // Report e-Purchase
            Route::post('/Manager/EPurchase/PR/Print/', [EPurchaseManagerController::class, 'print_pr_manager'])->name('print_pr_manager');
            Route::post('/Manager/EPurchase/PO/Print/', [EPurchaseManagerController::class, 'print_po_manager'])->name('print_po_manager');
            // Show Modal Data
            Route::get('show_modal_pr_manager/{id}', [EPurchaseManagerController::class, 'show_modal_pr_manager'])->name('show_modal_pr_manager');
            Route::get('show_modal_po_price_manager/{id}', [EPurchaseManagerController::class, 'show_modal_po_price_manager'])->name('show_modal_po_price_manager');
            Route::get('show_modal_po_price_manager_comp/{id}', [EPurchaseManagerController::class, 'show_modal_po_price_manager_comp'])->name('show_modal_po_price_manager_comp');
        });
        // Route::middleware(['auth', 'userLevel:2'])->group(function () {
        //     echo json_encode("User Level = 2");
        // });

        Route::middleware(['auth', 'userLevel:3'])->group(function () {
            // Client
            Route::get('/Users/Client/List', [UsersUsersController::class, 'index_client_users'])->name('index_client_users');
            Route::get('/Users/Client/Create', [UsersUsersController::class, 'create_client_users'])->name('create_client_users');
            Route::post('/Users/Client/Store', [UsersUsersController::class, 'store_client_users'])->name('store_client_users');
            Route::get('/Users/Client/Edit/{id}', [UsersUsersController::class, 'edit_client_users'])->name('edit_client_users');
            Route::POST('/Users/Client/Update/{id}', [UsersUsersController::class, 'update_client_users'])->name('update_client_users');
            Route::delete('/Users/Client/Destroy/{id}', [UsersUsersController::class, 'destroy_client_users'])->name('destroy_client_users');
            // JobNumber
            Route::get('/Users/JobNumber/List', [UsersUsersController::class, 'index_jn_users'])->name('index_jn_users');
            Route::get('/Users/JobNumber/List/Old', [UsersUsersController::class, 'index_jn_old_users'])->name('index_jn_old_users');
            Route::get('/Users/JobNumber/Show/JN/{id}', [UsersUsersController::class, 'show_jn_users'])->name('show_jn_users');
            Route::get('/Users/JobNumber/Show/JN_OLD/{id}', [UsersUsersController::class, 'show_jn_old_users'])->name('show_jn_old_users');
            Route::post('/Users/JobNumber/Store', [UsersUsersController::class, 'store_jn_users'])->name('store_jn_users');
            Route::get('/Users/JobNumber/Edit/{id}', [UsersUsersController::class, 'edit_jn_users'])->name('edit_jn_users');
            Route::POST('/Users/JobNumber/Update/{id}', [UsersUsersController::class, 'update_jn_users'])->name('update_jn_users');
            Route::delete('/Users/JobNumber/Destroy/{id}', [UsersUsersController::class, 'destroy_jn_users'])->name('destroy_jn_users');
            Route::get('/List_JNUsers', [UsersUsersController::class, 'refresh_jn_users'])->name('refresh_jn_users');
            // E-Purchase
            Route::get('/Users/Epurchase/List', [UsersEPurchaseController::class, 'index_pr_users'])->name('index_pr_users');
            Route::get('/Users/Epurchase/Create', [UsersEPurchaseController::class, 'create_pr_users'])->name('create_pr_users');
            Route::post('/Users/Epurchase/Store', [UsersEPurchaseController::class, 'store_pr_users'])->name('store_pr_users');
            Route::get('/refresh/pr/users', [UsersEPurchaseController::class, 'refresh_pr_users'])->name('refresh_pr_users');
            Route::get('show_modal_pr_users/{id}', [UsersEPurchaseController::class, 'show_modal_pr_users'])->name('show_modal_pr_users');
            Route::get('show_modal_po_pirce_users/{id}', [UsersEPurchaseController::class, 'show_modal_po_pirce_users'])->name('show_modal_po_pirce_users');
            Route::get('show_modal_po_un_users/{id}', [UsersEPurchaseController::class, 'show_modal_po_un_users'])->name('show_modal_po_un_users');
            Route::get('/Users/Epurchase/PR/OLD', [UsersUsersController::class, 'index_old_pr_users'])->name('index_old_pr_users');
            // Edit PR
            Route::get('show_modal_pr_users_edit/{id}', [UsersEPurchaseController::class, 'show_modal_pr_users_edit'])->name('show_modal_pr_users_edit');
            Route::get('show_modal_pr_users_add/{id}', [UsersEPurchaseController::class, 'show_modal_pr_users_add'])->name('show_modal_pr_users_add');
            Route::POST('update_pr_users', [UsersEPurchaseController::class, 'update_pr_users'])->name('update_pr_users');
            Route::POST('update_item_pr_users', [UsersEPurchaseController::class, 'update_item_pr_users'])->name('update_item_pr_users');
            // Print e-Purchase
            Route::post('/Users/EPurchase/PR/Print/', [UsersEPurchaseController::class, 'print_pr_users'])->name('print_pr_users');
            Route::post('/Users/EPurchase/PO/Print/', [UsersEPurchaseController::class, 'print_po_users'])->name('print_po_users');
            // Etc
            // ATK
            Route::get('/Users/ATK/Master/List', [UsersEPurchaseController::class, 'index_atk'])->name('index_atk_users');
            Route::post('/Users/ATK/Master/Store', [UsersEPurchaseController::class, 'store_atk'])->name('store_atk_users');
            Route::get('/Users/ATK/Master/Update', [UsersEPurchaseController::class, 'update_atk'])->name('update_atk_users');
            Route::get('/Users/ATK/Master/Create', [UsersEPurchaseController::class, 'create_atk'])->name('show_modal_create_atk');

            // Letter Number
            // Route::get('/Users/LetterNumber', [UsersUsersController::class, 'index_letter_users'])->name('index_letter_number_users');
            // Route::post('/Users/LetterNumber/Store', [UsersUsersController::class, 'store_letter_users'])->name('store_letter_number_users');
            // Route::get('/Users/LetterNumber/Store/Create', [UsersUsersController::class, 'show_letter_users'])->name('show_modal_create_letter_number_users');
            // Route::get('/refresh/number/users', [UsersUsersController::class, 'refresh_last_number_letter_users'])->name('refresh_last_number_letter_users');
            // Adds on
            Route::get('/users/data/json', [UsersUsersController::class, 'get_old_pr_users'])->name('get_old_pr_users');
        });

        Route::middleware(['auth', 'userLevel:4'])->group(function () {
            //  JobNumber
            Route::get('/HRGA/JobNumber/List', [HRJobNumberController::class, 'index_jn'])->name('index_jn_hr_ga');
            Route::get('/HRGA/JobNumber/List/Old', [HRJobNumberController::class, 'index_old_jn'])->name('index_jn_old_hr_ga');
            Route::get('/HRGA/JobNumber/Show/JN_OLD/{id}', [HRJobNumberController::class, 'show_jn_old_hr_ga'])->name('show_jn_old_hr_ga');
            Route::get('/HRGA/JobNumber/Create', [HRJobNumberController::class, 'create'])->name('create_jn_hr_ga');
            Route::post('/HRGA/JobNumber/Store', [HRJobNumberController::class, 'store_jn'])->name('store_jn_hr_ga');
            Route::get('/HRGA/JobNumber/Edit/{id}', [HRJobNumberController::class, 'edit'])->name('edit_jn_hr_ga');
            Route::POST('/HRGA/JobNumber/Update/{id}', [HRJobNumberController::class, 'update'])->name('update_jn_hr_ga');
            Route::delete('/HRGA/JobNumber/Destroy/{id}', [HRJobNumberController::class, 'destroy'])->name('destroy_jn_hr_ga');
            Route::get('/List_JN', [HRJobNumberController::class, 'refresh_jn_hr_ga'])->name('refresh_jn_hr_ga');
            // Client
            Route::get('/HRGA/Client/List', [HRJobNumberController::class, 'index_client'])->name('index_client_hr_ga');
            // Route::get('/HRGA/Client/Create', [HRJobNumberController::class, 'create'])->name('create_client_admin');
            Route::post('/HRGA/Client/Store', [HRJobNumberController::class, 'store_client'])->name('store_client_hr_ga');
            Route::get('/HRGA/Client/Edit/{id}', [HRJobNumberController::class, 'edit_client'])->name('edit_client_hr_ga');
            Route::POST('/HRGA/Client/Update/{id}', [HRJobNumberController::class, 'update_client'])->name('update_client_hr_ga');
            Route::delete('/HRGA/Client/Destroy/{id}', [HRJobNumberController::class, 'destroy_client'])->name('destroy_client_hr_ga');
            // Purchase Request
            Route::get('/HRGA/EPurchase/PR/List', [HREpurchaseController::class, 'index_pr'])->name('index_pr_hr_ga');
            Route::get('/HRGA/EPurchase/PR/Create', [HREpurchaseController::class, 'create_pr'])->name('create_pr_hr_ga');
            Route::POST('/HRGA/EPurchase/PR/Store', [HREpurchaseController::class, 'store_pr'])->name('store_pr_hr_ga');
            Route::get('/HRGA/EPurchase/PR/Edit/{id}', [HREpurchaseController::class, 'edit_pr'])->name('edit_pr_hr_ga');
            Route::POST('/HRGA/EPurchase/PR/Update/{id}', [HREpurchaseController::class, 'update_pr'])->name('update_pr_hr_ga');
            Route::delete('/HRGA/EPurchase/PR/Destroy/{id}', [HREpurchaseController::class, 'destroy_pr'])->name('destroy_pr_hr_ga');
            Route::get('/HRGA/refresh/pr', [HREpurchaseController::class, 'refresh_pr_hr_ga'])->name('refresh_pr_hr_ga');
            Route::get('/HRGA/Epurchase/PR/OLD', [HREpurchaseController::class, 'index_old_pr_hr_ga'])->name('index_old_pr_hr_ga');
            // Purchase Order
            Route::get('/HRGA/EPurchase/PO/List', [HREpurchaseController::class, 'index_po'])->name('index_po_hr_ga');
            Route::get('/HRGA/EPurchase/PO/Create', [HREpurchaseController::class, 'create_po'])->name('create_po_hr_ga');
            Route::post('/HRGA/EPurchase/PO/Store', [HREpurchaseController::class, 'store_po'])->name('store_po_hr_ga');
            // Route::post('/HRGA/EPurchase/PO/Store', [HREpurchaseController::class, 'store_po_2'])->name('store_po_hr_ga');
            Route::post('/HRGA/EPurchase/PO/Price/Store', [HREpurchaseController::class, 'store_price'])->name('store_price_hr_ga');
            Route::get('/HRGA/EPurchase/PO/Edit/{id}', [HREpurchaseController::class, 'edit_po'])->name('edit_po_hr_ga');
            Route::POST('/HRGA/EPurchase/PO/Update/{id}', [HREpurchaseController::class, 'update_po'])->name('update_po_hr_ga');
            Route::delete('/HRGA/EPurchase/PO/Destroy/{id}', [HREpurchaseController::class, 'destroy_po'])->name('destroy_po_hr_ga');
            // Vendor
            Route::get('/HRGA/EPurchase/Vendor/List', [HREpurchaseController::class, 'index_vendor_hr_ga'])->name('index_vendor_hr_ga');
            Route::get('/HRGA/EPurchase/Vendor/Create', [HREpurchaseController::class, 'create_vendor'])->name('create_vendor_hr_ga');
            Route::post('/HRGA/EPurchase/Vendor/Store', [HREpurchaseController::class, 'store_vendor'])->name('store_vendor_hr_ga');
            Route::get('/HRGA/EPurchase/Vendor/Edit/{id}', [HREpurchaseController::class, 'edit_vendor'])->name('edit_vendor_hr_ga');
            Route::POST('/HRGA/EPurchase/Vendor/Update/{id}', [HREpurchaseController::class, 'update_vendor'])->name('update_vendor_hr_ga');
            Route::delete('/HRGA/EPurchase/Vendor/Destroy/{id}', [HREpurchaseController::class, 'destroy_vendor'])->name('destroy_vendor_hr_ga');
            // Approval
            Route::POST('/HRGA/EPurchase/PR/Approve', [HREpurchaseController::class, 'approve_pr_hr_ga'])->name('approve_pr_hr_ga');
            Route::POST('/HRGA/EPurchase/PR/Reject', [HREpurchaseController::class, 'reject_pr_hr_ga'])->name('reject_pr_hr_ga');

            // Print e-Purchase
            Route::post('/HRGA/EPurchase/PR/Print/', [HREpurchaseController::class, 'print_pr_hr_ga'])->name('print_pr_hr_ga');
            Route::post('/HRGA/EPurchase/PO/Print/', [HREpurchaseController::class, 'print_po_hr_ga'])->name('print_po_hr_ga');
            // Show Modal Data
            Route::get('show_modal_pr_hr_ga/{id}', [HREpurchaseController::class, 'show_modal_pr_hr_ga'])->name('show_modal_pr_hr_ga');
            Route::get('show_modal_price_hr_ga/{id}', [HREpurchaseController::class, 'show_modal_price_hr_ga'])->name('show_modal_price_hr_ga');
            Route::get('show_modal_po_hr_ga/{id}', [HREpurchaseController::class, 'show_modal_po_hr_ga'])->name('show_modal_po_hr_ga');
            Route::get('show_modal_create_po_hr_ga/{id}', [HREpurchaseController::class, 'show_modal_create_po_hr_ga'])->name('show_modal_create_po_hr_ga');
            // Report 
            Route::get('/HRGA/EPurchase/Search', [HREpurchaseController::class, 'search_epurchase_admin'])->name('search_epurchase_admin');
            Route::post('/HRGA/EPurchase/Search/Submit', [HREpurchaseController::class, 'search_epurchase_admin_result'])->name('search_epurchase_hr_ga');
            Route::get('/HRGA/EPurchase/Search/Print/PR/{id}', [HREpurchaseController::class, 'print_pr_epurchase_admin'])->name('print_pr_epurchase_admin');
            Route::get('/HRGA/EPurchase/Search/Print/PO/{id}', [HREpurchaseController::class, 'print_po_epurchase_admin'])->name('print_po_epurchase_admin');

            // Legalitas
            Route::get('/HRGA/Legalitas/Office', [HRGAController::class, 'index_legalitas'])->name('index_office_legalitas_hr_ga');
            Route::post('/HRGA/Legalitas/Office/Store', [HRGAController::class, 'store_legalitas'])->name('store_office_legalitas_hr_ga');
            Route::post('/HRGA/Legalitas/Office/Update', [HRGAController::class, 'update_legalitas'])->name('update_office_legalitas_hr_ga');
            Route::get('/HRGA/Legalitas/Office/Edit/{id}', [HRGAController::class, 'edit_legalitas'])->name('edit_office_legalitas_hr_ga');

            // Inventory
            Route::get('/HRGA/Inventory/List', [InventoryController::class, 'index_furniture'])->name('index_furniture');
            Route::post('/HRGA/Inventory/Store', [InventoryController::class, 'store_furniture'])->name('store_furniture');
            Route::get('/HRGA/Inventory/Edit/{id}', [InventoryController::class, 'edit_furniture'])->name('edit_furniture');
            Route::post('/HRGA/Inventory/Update', [InventoryController::class, 'update_furniture'])->name('update_furniture');
            Route::delete('/HRGA/Inventory/Destroy/{id}', [InventoryController::class, 'destroy_furniture'])->name('destroy_furniture');
            Route::get('/HRGA/Inventory/QRCode', [InventoryController::class, 'generateQR'])->name('generateQR');
            // Letter Number
            // Route::get('/HRGA/LetterNumber', [LetterNumberController::class, 'index'])->name('index_letter_number');
            // Route::post('/HRGA/LetterNumber/Store', [LetterNumberController::class, 'store'])->name('store_letter_number');
            // Route::get('/HRGA/LetterNumber/Store/Create', [LetterNumberController::class, 'show'])->name('show_modal_create_letter_number');
            // Route::get('/refresh/number', [LetterNumberController::class, 'refresh_last_number'])->name('refresh_last_number');

            // Adds on
            Route::get('/HRGA/data/json', [HREpurchaseController::class, 'get_old_pr_hr_ga'])->name('get_old_pr_hr_ga');
        });
    });
});
