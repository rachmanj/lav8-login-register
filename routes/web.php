<?php

use App\Http\Controllers\AccountingController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PendingdocsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserdataController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/outsdocs/011', [PendingdocsController::class, 'outsdocs011'])->name('outsdocs011.index');
    Route::get('/outsdocs/017', [PendingdocsController::class, 'outsdocs017'])->name('outsdocs017.index');
    Route::get('/outsdocs/APS', [PendingdocsController::class, 'outsdocsAPS'])->name('outsdocsAPS.index');

    // Data Controller
    Route::get('/outsdocs/011/data', [DataController::class, 'index011'])->name('index011.data');
    Route::get('/outsdocs/017/data', [DataController::class, 'index017'])->name('index017.data');
    Route::get('/outsdocs/APS/data', [DataController::class, 'indexAPS'])->name('indexAPS.data');
    Route::get('/accounting/index/data', [DataController::class, 'accountingIndex'])->name('accountingIndex.data');
    Route::get('/accounting/000H/data', [DataController::class, 'index000H'])->name('accounting000H.data');
    Route::get('/accounting/001H/data', [DataController::class, 'index001H'])->name('accounting001H.data');
    Route::get('/accounting/invoices/data', [DataController::class, 'accountingInvoices'])->name('accountingInvoices.data');
    Route::get('/accounting/addocs/{inv_id}/data', [DataController::class, 'addocsByInvoice'])->name('addocsByInvoice.data');

    // Invoice
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');

    // Accounting
    Route::get('/accounting/addocs', [AccountingController::class, 'outdocs_index'])->name('accounting.outdocs_index');
    Route::get('/accounting/addocs/000H', [AccountingController::class, 'outsdocs000H'])->name('accounting.outdocs_000H');
    Route::get('/accounting/addocs/001H', [AccountingController::class, 'outsdocs001H'])->name('accounting.outdocs_001H');
    Route::get('/accounting/addocs/edit/{id}', [AccountingController::class, 'edit_addoc'])->name('accounting.edit_addoc');
    Route::put('/accounting/addocs/{id}', [AccountingController::class, 'update_addoc'])->name('accounting.update_addoc');
    Route::get('/accounting/invoices', [AccountingController::class, 'invoices'])->name('accounting.invoices');
    Route::get('/accounting/addocs/{inv_id}/add', [AccountingController::class, 'add_addoc'])->name('accounting.add_addoc');
    Route::post('/accounting/addocs/{inv_id}', [AccountingController::class, 'store_addoc'])->name('accounting.store_addoc');
    Route::delete('/accounting/addocs/{id}', [AccountingController::class, 'destroy_addoc'])->name('accounting.destroy_addoc');

    //Users
    Route::get('/admin/activate', [UserController::class, 'activate_index'])->name('user.activate_index');
    Route::put('/admin/activate/{id}', [UserController::class, 'activate_update'])->name('user.activate_update');
    Route::get('/admin/deactivate', [UserController::class, 'deactivate_index'])->name('user.deactivate_index');
    Route::put('/admin/deactivate/{id}', [UserController::class, 'deactivate_update'])->name('user.deactivate_update');
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('users.update');
    
    Route::get('/admin/users/index/data', [UserdataController::class, 'index_data'])->name('users.index.data');
    Route::get('/admin/users/activate/data', [UserdataController::class, 'user_activate'])->name('user_activate.data');
    Route::get('/admin/users/deactivate/data', [UserdataController::class, 'user_deactivate'])->name('user_deactivate.data');
});

