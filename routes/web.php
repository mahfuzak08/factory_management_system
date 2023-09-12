<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\BankaccController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome'); // welcome page for website
    // redirect to login page, when just enter the domain name
    return redirect('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/sales', [SalesController::class, 'index'])->name('sales');
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
    
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase');
    Route::post('/save_purchase', [PurchaseController::class, 'set_purchase'])->name('save-purchase');
    Route::get('/purchase_invoice/{id}', [PurchaseController::class, 'invoice'])->name('purchase-invoice');
    // Route::get('/edit_purchase/{id}', [PurchaseController::class, 'edit_purchase'])->name('edit-purchase');
    // Route::post('/edit_purchase/{id}', [PurchaseController::class, 'update_purchase'])->name('edit-purchase');
    // Route::get('/delete_purchase/{id}', [PurchaseController::class, 'delete_purchase'])->name('delete-purchase');
    // Route::get('/purchase_details/{id}', [PurchaseController::class, 'see_purchase'])->name('purchase-details');
    // Route::post('/save_purchase_amount', [PurchaseController::class, 'add_amount'])->name('save-purchase-amount');

    Route::get('/vendor', [VendorController::class, 'index'])->name('vendor');
    Route::get('/add_new_vendor', [VendorController::class, 'open_vendor_form'])->name('add-new-vendor');
    Route::post('/save_vendor', [VendorController::class, 'set_vendor'])->name('save-vendor');
    Route::get('/edit_vendor/{id}', [VendorController::class, 'edit_vendor'])->name('edit-vendor');
    Route::post('/edit_vendor/{id}', [VendorController::class, 'update_vendor'])->name('edit-vendor');
    Route::get('/delete_vendor/{id}', [VendorController::class, 'delete_vendor'])->name('delete-vendor');
    Route::get('/vendor_details/{id}', [VendorController::class, 'see_vendor'])->name('vendor-details');
    Route::post('/save_vendor_amount', [VendorController::class, 'add_amount'])->name('save-vendor-amount');
    
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');
    Route::get('/expense', [ExpenseController::class, 'index'])->name('expense');

    Route::get('/bank_account', [BankaccController::class, 'index'])->name('bank_account');
    Route::get('/add_new_account', [BankaccController::class, 'open_account_form'])->name('add-new-account');
    Route::post('/save_account', [BankaccController::class, 'set_account'])->name('save-account');
    Route::get('/edit_account/{id}', [BankaccController::class, 'edit_account'])->name('edit-account');
    Route::post('/edit_account/{id}', [BankaccController::class, 'update_account'])->name('edit-account');
    Route::get('/delete_account/{id}', [BankaccController::class, 'delete_account'])->name('delete-account');
    Route::get('/account_details/{id}', [BankaccController::class, 'acc_details'])->name('account-details');
    Route::post('/save_amount', [BankaccController::class, 'add_amount'])->name('save-amount');

});
