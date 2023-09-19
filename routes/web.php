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
    Route::post('/save_sales', [SalesController::class, 'set_sales'])->name('save-sales');
    Route::get('/sales_invoice/{id}', [SalesController::class, 'invoice'])->name('sales-invoice');

    Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
    Route::get('/add_new_customer', [CustomerController::class, 'open_customer_form'])->name('add-new-customer');
    Route::post('/save_customer', [CustomerController::class, 'set_customer'])->name('save-customer');
    Route::get('/edit_customer/{id}', [CustomerController::class, 'edit_customer'])->name('edit-customer');
    Route::post('/edit_customer/{id}', [CustomerController::class, 'update_customer'])->name('edit-customer');
    Route::get('/delete_customer/{id}', [CustomerController::class, 'delete_customer'])->name('delete-customer');
    Route::get('/customer_details/{id}', [CustomerController::class, 'see_customer'])->name('customer-details');
    Route::post('/save_customer_amount', [CustomerController::class, 'add_amount'])->name('save-customer-amount');
    
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase');
    Route::post('/save_purchase', [PurchaseController::class, 'set_purchase'])->name('save-purchase');
    Route::get('/purchase_invoice/{id}', [PurchaseController::class, 'invoice'])->name('purchase-invoice');

    Route::get('/vendor', [VendorController::class, 'index'])->name('vendor');
    Route::get('/add_new_vendor', [VendorController::class, 'open_vendor_form'])->name('add-new-vendor');
    Route::post('/save_vendor', [VendorController::class, 'set_vendor'])->name('save-vendor');
    Route::get('/edit_vendor/{id}', [VendorController::class, 'edit_vendor'])->name('edit-vendor');
    Route::post('/edit_vendor/{id}', [VendorController::class, 'update_vendor'])->name('edit-vendor');
    Route::get('/delete_vendor/{id}', [VendorController::class, 'delete_vendor'])->name('delete-vendor');
    Route::get('/vendor_details/{id}', [VendorController::class, 'see_vendor'])->name('vendor-details');
    Route::post('/save_vendor_amount', [VendorController::class, 'add_amount'])->name('save-vendor-amount');
    
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');
    Route::get('/add_new_employee', [EmployeeController::class, 'open_employee_form'])->name('add-new-employee');
    Route::post('/save_employee', [EmployeeController::class, 'set_employee'])->name('save-employee');
    Route::get('/edit_employee/{id}', [EmployeeController::class, 'edit_employee'])->name('edit-employee');
    Route::post('/edit_employee/{id}', [EmployeeController::class, 'update_employee'])->name('edit-employee');
    Route::get('/delete_employee/{id}', [EmployeeController::class, 'delete_employee'])->name('delete-employee');
    Route::get('/employee_details/{id}', [EmployeeController::class, 'see_employee'])->name('employee-details');
    Route::post('/save_employee_amount', [EmployeeController::class, 'add_amount'])->name('save-employee-amount');

    Route::get('/expense', [ExpenseController::class, 'index'])->name('expense');
    Route::get('/add_new_expense', [ExpenseController::class, 'open_expense_form'])->name('add-new-expense');
    Route::post('/save_expense', [ExpenseController::class, 'set_expense'])->name('save-expense');
    Route::get('/edit_expense/{id}', [ExpenseController::class, 'edit_expense'])->name('edit-expense');
    Route::post('/edit_expense/{id}', [ExpenseController::class, 'update_expense'])->name('edit-expense');
    Route::get('/delete_expense/{id}', [ExpenseController::class, 'delete_expense'])->name('delete-expense');
    Route::get('/expense_details/{id}', [ExpenseController::class, 'expense_details'])->name('expense-details');
    Route::post('/save_expense_amount', [ExpenseController::class, 'add_expense_amount'])->name('save-expense-amount');

    Route::get('/bank_account', [BankaccController::class, 'index'])->name('bank_account');
    Route::get('/add_new_account', [BankaccController::class, 'open_account_form'])->name('add-new-account');
    Route::post('/save_account', [BankaccController::class, 'set_account'])->name('save-account');
    Route::get('/edit_account/{id}', [BankaccController::class, 'edit_account'])->name('edit-account');
    Route::post('/edit_account/{id}', [BankaccController::class, 'update_account'])->name('edit-account');
    Route::get('/delete_account/{id}', [BankaccController::class, 'delete_account'])->name('delete-account');
    Route::get('/account_details/{id}', [BankaccController::class, 'acc_details'])->name('account-details');
    Route::post('/save_amount', [BankaccController::class, 'add_amount'])->name('save-amount');

});
