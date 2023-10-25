<?php

use App\Http\Controllers\AccountingController;
use App\Http\Controllers\AccountingdoktamController;
use App\Http\Controllers\AccountinglpdController;
use App\Http\Controllers\AccountingsentController;
use App\Http\Controllers\AccountingspiController;
use App\Http\Controllers\AdditionaldocController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DoktamController;
use App\Http\Controllers\DoktamDashboardController;
use App\Http\Controllers\DoktamdataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogisticItoUploadController;
use App\Http\Controllers\LogisticItoMonitoringController;
use App\Http\Controllers\LogisticSiteMonitoringController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentDetailController;
use App\Http\Controllers\PendingdocsController;
use App\Http\Controllers\RecaddocController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\Report2Controller;
use App\Http\Controllers\ReportsGroup2Controller;
use App\Http\Controllers\ReportsGroup3Controller;
use App\Http\Controllers\ReportsGroup4Controller;
use App\Http\Controllers\ReportsReconcileController;
use App\Http\Controllers\SpiController;
use App\Http\Controllers\SpiLogisticController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserdataController;
use App\Http\Controllers\VendorbranchController;
use App\Http\Controllers\WaitPaymentController;

use App\Models\Doktam;
use Illuminate\Support\Facades\Route;


Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Accounting menu Daftar SPI
    Route::get('/accounting/spis/data', [AccountingspiController::class, 'spi_index_data'])->name('accounting.spi_index.data');

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
    
    // Accounting - Dokumen Tambahan (doktams)
    Route::get('/accounting/doktams/invoices/{inv_id}', [AccountingdoktamController::class, 'invoices_show'])->name('accounting.doktam_invoices.show');
    Route::post('/accounting/doktams/invoices/{inv_id}', [AccountingdoktamController::class, 'doktam_add'])->name('accounting.doktam.add');
    Route::delete('/accounting/doktams/invoices/{id}/delete', [AccountingdoktamController::class, 'doktam_delete'])->name('accounting.doktam_delete');
    Route::get('/accounting/doktams/invoices', [AccountingdoktamController::class, 'invoices_index'])->name('accounting.doktam_invoices.index');
    Route::get('/accounting/doktams/{id}/edit', [AccountingdoktamController::class, 'edit_doktam'])->name('edit_doktam');
    Route::put('/accounting/doktams/{id}/update', [AccountingdoktamController::class, 'update_doktam'])->name('update_doktam');
    
    // Doktam Data
    Route::get('/accounting/doktams/data/invoices', [DoktamdataController::class, 'doktam_invoices'])->name('doktam_invoices.data');
    
    // ---------------

    // Accounting menu Sent Invoice
    Route::get('/accounting/sent', [AccountingsentController::class, 'sent_index'])->name('sent_index');
    Route::delete('/accounting/sent/{id}', [AccountingsentController::class, 'add_tocart'])->name('add_tocart');
    Route::delete('/accounting/sent/remove/{id}', [AccountingsentController::class, 'remove_fromcart'])->name('remove_fromcart');
    Route::get('/accounting/sent/view_spi', [AccountingsentController::class, 'view_spi'])->name('view_spi');
    Route::get('/accounting/sent/spi_pdf', [AccountingsentController::class, 'spi_pdf'])->name('spi_pdf');
    Route::get('/accounting/sent/create_spi', [AccountingsentController::class, 'create_spi'])->name('create_spi');
    Route::post('/accounting/sent/store_spi', [AccountingsentController::class, 'store_spi'])->name('store_spi');

    Route::get('/accounting/sent/invoices/data', [AccountingsentController::class, 'tosent_index_data'])->name('tosent_index.data');
    Route::get('/accounting/sent/cart/data', [AccountingsentController::class, 'cart_index_data'])->name('cart_index.data');
    // -----------------

    // Accounting SPI menu
    Route::get('/accounting/spis', [AccountingspiController::class, 'spi_index'])->name('accounting.spi_index');
    Route::get('/accounting/spis/{id}', [AccountingspiController::class, 'spi_detail'])->name('accounting.spi_detail');
    Route::get('/accounting/spis/{id}/print', [AccountingspiController::class, 'spi_print_pdf'])->name('accounting.spi_print_pdf');
    Route::get('/accounting/spi-info/{id}/print', [AccountingspiController::class, 'spiInfo_print_pdf'])->name('accounting.spiInfo_print_pdf');
    
    //USERS
    Route::prefix('admin')->group(function () {
        Route::get('/activate', [UserController::class, 'activate_index'])->name('user.activate_index');
        Route::put('/activate/{id}', [UserController::class, 'activate_update'])->name('user.activate_update');
        Route::get('/deactivate', [UserController::class, 'deactivate_index'])->name('user.deactivate_index');
        Route::put('/deactivate/{id}', [UserController::class, 'deactivate_update'])->name('user.deactivate_update');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::get('/{id}/change-password', [UserController::class, 'change_password'])->name('users.change_password');
        Route::put('/{id}/password-update', [UserController::class, 'password_update'])->name('users.password_update');
        
        Route::get('/users/index/data', [UserdataController::class, 'index_data'])->name('users.index.data');
        Route::get('/users/activate/data', [UserdataController::class, 'user_activate'])->name('user_activate.data');
        Route::get('/users/deactivate/data', [UserdataController::class, 'user_deactivate'])->name('user_deactivate.data');
    });
    
    Route::prefix('accounting/lpds')->name('accounting.lpd.')->group(function () {
        Route::get('/', [AccountinglpdController::class, 'index'])->name('index');
        Route::get('/invoice_cart', [AccountinglpdController::class, 'invoice_cart'])->name('invoice_cart');
        Route::get('/view_cart_detail', [AccountinglpdController::class, 'view_cart_detail'])->name('view_cart_detail');
        Route::delete('/{inv_id}/addto_cart', [AccountinglpdController::class, 'addto_cart'])->name('addto_cart');
        Route::delete('/{inv_id}/removefrom_cart', [AccountinglpdController::class, 'removefrom_cart'])->name('removefrom_cart');
        Route::get('/create', [AccountinglpdController::class, 'create'])->name('create');
        Route::post('/', [AccountinglpdController::class, 'store'])->name('store');
        Route::get('/{id}/lpd_detail', [AccountinglpdController::class, 'lpd_detail'])->name('lpd_detail');
        Route::get('/{id}/view_pdf', [AccountinglpdController::class, 'lpd_view_pdf'])->name('lpd_view_pdf');
    
        Route::get('/data', [AccountinglpdController::class, 'index_data'])->name('index.data');
        Route::get('/tosend/data', [AccountinglpdController::class, 'tosend_data'])->name('tosend.data');
        Route::get('/incart/data', [AccountinglpdController::class, 'incart_data'])->name('incart.data');
    });

    // Menu pending doktams
    Route::prefix('doktams')->name('doktams.')->group(function () {
        Route::get('/data', [DoktamController::class, 'index_data'])->name('index.data');
        
        Route::get('/export-excel', [DoktamController::class, 'export_excel'])->name('export_excel');
        // Route::get('/test', [DoktamController::class, 'test'])->name('test');
        Route::get('/', [DoktamController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [DoktamController::class, 'edit'])->name('edit');
        Route::get('/{id}', [DoktamController::class, 'show'])->name('show');
        Route::put('/{id}', [DoktamController::class, 'update'])->name('update');
        Route::post('/comments', [DoktamController::class, 'post_comment'])->name('post_comment');
    });

    // Menu invoices
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/data', [InvoiceController::class, 'index_data'])->name('data');
        Route::get('/possible/{inv_id}/data', [InvoiceController::class, 'possible_doktams_data'])->name('possible_data');
        Route::get('/{inv_id}/data', [InvoiceController::class, 'doktams_of_invoice_data'])->name('doktams_of_invoice.data');

        Route::put('/addto_invoice/{id}', [InvoiceController::class, 'addto_invoice'])->name('addto_invoice');
        Route::put('/removefrom_invoice/{id}', [InvoiceController::class, 'removefrom_invoice'])->name('removefrom_invoice');

        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/create', [InvoiceController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [InvoiceController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [InvoiceController::class, 'update'])->name('update');
        Route::get('/{id}', [InvoiceController::class, 'show'])->name('show');
        Route::get('/{inv_id}/add_doktams', [InvoiceController::class, 'add_doktams'])->name('add_doktams');
        Route::post('/', [InvoiceController::class, 'store'])->name('store');
    });

    // Menu addtional documents -> menggunakan table doktams
    Route::prefix('additionaldocs')->name('additionaldocs.')->group(function () {
         // SEARCH ADDITIONAL DOCUMENT
        Route::prefix('search')->name('search.')->group(function () {
            Route::get('/', [AdditionaldocController::class, 'search_index'])->name('index');
            Route::post('/', [AdditionaldocController::class, 'search_result'])->name('search_result');
            // Route::get('/search/data', [AdditionaldocController::class, 'search_data'])->name('search.data');
        });

        // RECEIVE & NEW ADDITIONAL DOCUMENT
        Route::prefix('receive')->name('receive.')->group(function () {
            Route::get('/data', [AdditionaldocController::class, 'index_data'])->name('data');
            Route::get('/', [AdditionaldocController::class, 'index'])->name('index');
            Route::get('/create', [AdditionaldocController::class, 'create'])->name('create');
            Route::post('/', [AdditionaldocController::class, 'store'])->name('store');
            Route::get('/{id}', [AdditionaldocController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdditionaldocController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdditionaldocController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/report1/data', [ReportsController::class, 'report1_data'])->name('report1.data');
        Route::get('/report3/data', [ReportsController::class, 'report3_data'])->name('report3.data');
        Route::get('/report4/data', [ReportsController::class, 'report4_data'])->name('report4.data');
        Route::get('/report5/data', [ReportsController::class, 'report5_data'])->name('report5.data');
        Route::get('/report99/data', [ReportsController::class, 'report99_data'])->name('report99.data');
    
        Route::get('/', [ReportsController::class, 'index'])->name('index');
        Route::get('/report1', [ReportsController::class, 'report1'])->name('report1');

        // List Invoice vs possibe doktams (doktams yg belum ada ivnoicesnya vs invoice dgn PO yg sama dgn PO di doktams).
        Route::prefix('report2')->name('report2.')->group(function () {
            Route::get('/data', [Report2Controller::class, 'data'])->name('data');
            Route::get('/', [Report2Controller::class, 'index'])->name('index'); 
            Route::get('/{invoice_id}', [Report2Controller::class, 'show'])->name('show');
            Route::put('/addto_invoice/{id}', [Report2Controller::class, 'addto_invoice'])->name('addto_invoice');
            Route::put('/removefrom_invoice/{id}', [Report2Controller::class, 'removefrom_invoice'])->name('removefrom_invoice');
 
        });

        Route::get('/report3', [ReportsController::class, 'report3'])->name('report3');
        Route::get('/report4', [ReportsController::class, 'report4'])->name('report4');
        Route::get('/report5', [ReportsController::class, 'report5'])->name('report5');
        Route::get('/report5/{id}', [ReportsController::class, 'report5_edit'])->name('report5.edit');
        Route::put('/report5/{id}', [ReportsController::class, 'report5_update'])->name('report5.update');
    
        Route::get('/report7', [ReportsGroup2Controller::class, 'report7_index'])->name('report7.index');
        Route::get('/report7/data/', [ReportsGroup2Controller::class, 'report7_data'])->name('report7.data');
        Route::get('/report7/{id}/edit', [ReportsGroup2Controller::class, 'report7_edit'])->name('report7.edit');
        Route::put('/report7/{id}', [ReportsGroup2Controller::class, 'report7_update'])->name('report7.update');
    
        Route::get('report8', [ReportsGroup2Controller::class, 'report8_index'])->name('report8.index');
        Route::get('/report8/data/', [ReportsGroup2Controller::class, 'report8_data'])->name('report8.data');
        Route::get('/report8/{id}/show', [ReportsGroup2Controller::class, 'report8_show'])->name('report8.show');
    
        Route::get('report9', [ReportsGroup2Controller::class, 'report9_index'])->name('report9.index');
        Route::post('/report9/display', [ReportsGroup2Controller::class, 'report9_display'])->name('report9.display');
        Route::get('/report9/{id}/show', [ReportsGroup2Controller::class, 'report9_show'])->name('report9.show');
    
        Route::get('report10', [ReportsGroup3Controller::class, 'report10_index'])->name('report10.index');
        Route::post('report10/display', [ReportsGroup3Controller::class, 'report10_display'])->name('report10.display');
        Route::get('report10/{id}/edit', [ReportsGroup3Controller::class, 'report10_edit'])->name('report10.edit');
        Route::put('report10/{id}/update', [ReportsGroup3Controller::class, 'report10_update'])->name('report10.update');
    
        Route::get('report11', [ReportsGroup3Controller::class, 'report11_index'])->name('report11.index');
        Route::post('report11/display', [ReportsGroup3Controller::class, 'report11_display'])->name('report11.display');
        Route::get('report11/{id}/edit', [ReportsGroup3Controller::class, 'report11_edit'])->name('report11.edit');
        Route::put('report11/{id}/update', [ReportsGroup3Controller::class, 'report11_update'])->name('report11.update');
    
        Route::get('report12/', [ReportsGroup4Controller::class, 'report12_index'])->name('report12.index');
        Route::get('report12/{id}/edit', [ReportsGroup4Controller::class, 'report12_edit'])->name('report12.edit');
        Route::put('report12/{id}', [ReportsGroup4Controller::class, 'report12_update'])->name('report12.update');
        Route::get('report12/data', [ReportsGroup4Controller::class, 'report12_index_data'])->name('report12.index.data');
        Route::get('report12/no-doc', [ReportsGroup4Controller::class, 'report12_nodocs_index'])->name('report12.nodocs_index');
        Route::get('report12/no-doc/data', [ReportsGroup4Controller::class, 'report12_index_nodocs_data'])->name('report12.nodocs_index.data');
    
        Route::get('/report98', [ReportsController::class, 'report98'])->name('report98');
        Route::post('/report98/display', [ReportsController::class, 'report98_display'])->name('report98_display');
        Route::put('/report98/{id}', [ReportsController::class, 'report98_update'])->name('report98.update');
    
        Route::get('/report99', [ReportsController::class, 'report99'])->name('report99');
        Route::get('/report99/{id}', [ReportsController::class, 'report99_edit'])->name('report99.edit');
        Route::put('/report99/{id}', [ReportsController::class, 'report99_update'])->name('report99.update');

        Route::prefix('reconcile')->name('reconcile.')->group(function () {
            Route::get('/', [ReportsReconcileController::class, 'index'])->name('index');
            Route::get('/data', [ReportsReconcileController::class, 'data'])->name('data');
            Route::post('/upload', [ReportsReconcileController::class, 'upload'])->name('upload');
            Route::get('/delete-mine', [ReportsReconcileController::class, 'delete_mine'])->name('delete_mine');
            Route::get('/export', [ReportsReconcileController::class, 'export'])->name('export');
        });
        
    });

    Route::get('payments/data', [PaymentController::class, 'index_data'])->name('payments.index.data');
    Route::resource('payments', PaymentController::class);

    Route::prefix('payment-details')->name('payment_details.')->group(function () {
        Route::get('/invtopay/data', [PaymentDetailController::class, 'invoice_topay_data'])->name('invtopay.data');
        Route::get('/invincart/data', [PaymentDetailController::class, 'invoice_incart_data'])->name('inv_incart.data');
        Route::get('/create', [PaymentDetailController::class, 'create'])->name('create');
        Route::put('/{inv_id}/add_tocart', [PaymentDetailController::class, 'add_tocart'])->name('add_tocart');
        Route::put('/{inv_id}/remove_fromcart', [PaymentDetailController::class, 'remove_fromcart'])->name('remove_fromcart');
    });

    //WAIT PAYMENT
    Route::prefix('wait-payment')->name('wait-payment.')->group(function () {
        Route::get('/', [WaitPaymentController::class, 'index'])->name('index');
        Route::get('/data', [WaitPaymentController::class, 'data'])->name('data');
        Route::put('/{id}/send', [WaitPaymentController::class, 'send'])->name('send');
    });

    // SPIS
    Route::prefix('spis')->name('spis.')->group(function () {
        // GENERAL
        Route::prefix('general')->name('general.')->group(function () {
            Route::get('/data', [SpiController::class, 'data'])->name('data');
            Route::get('/', [SpiController::class, 'index'])->name('index');
            Route::get('/{spi_id}/receive', [SpiController::class, 'receive'])->name('receive');
            Route::put('/{spi_id}/update', [SpiController::class, 'receive_update'])->name('receive.update');
        });

        // LOGISTIC
        Route::prefix('logistic')->name('logistic.')->group(function () {
            Route::get('/data', [SpiLogisticController::class, 'data'])->name('data');
            Route::get('/to_cart/data', [SpiLogisticController::class, 'to_cart_data'])->name('to_cart.data');
            Route::get('/in_cart/data', [SpiLogisticController::class, 'in_cart_data'])->name('in_cart.data');
            Route::get('/in_cart_edit/data', [SpiLogisticController::class, 'in_cart_data_edit'])->name('in_cart_data_edit.data');
            Route::get('/', [SpiLogisticController::class, 'index'])->name('index');
            Route::get('/create', [SpiLogisticController::class, 'create'])->name('create');
            Route::post('/', [SpiLogisticController::class, 'store'])->name('store');
            Route::get('/{spi_id/add_documents', [SpiLogisticController::class, 'add_documents'])->name('add_documents');
            Route::post('/add_tocart', [SpiLogisticController::class, 'add_tocart'])->name('add_tocart');
            Route::post('/remove_fromcart', [SpiLogisticController::class, 'remove_fromcart'])->name('remove_fromcart');
            Route::get('/move_all_tocart', [SpiLogisticController::class, 'move_all_tocart'])->name('move_all_tocart');
            Route::get('/remove_all_fromcart', [SpiLogisticController::class, 'remove_all_fromcart'])->name('remove_all_fromcart');
            Route::get('/{spi_id}/print', [SpiLogisticController::class, 'print'])->name('print');
            Route::get('/{spi_id}/show', [SpiLogisticController::class, 'show'])->name('show');
            Route::delete('/{spi_id}/destroy', [SpiLogisticController::class, 'destroy'])->name('destroy');
            Route::get('/{spi_id}/sent', [SpiLogisticController::class, 'sent'])->name('sent');
            Route::post('/store_doktam', [SpiLogisticController::class, 'store_doktam'])->name('store_doktam');
            Route::post('/destroy_doktam', [SpiLogisticController::class, 'destroy_doktam'])->name('destroy_doktam');
            // Route::get('/{spi_id}/edit', [SpiLogisticController::class, 'edit'])->name('edit');
            // Route::put('/{spi_id}/update', [SpiLogisticController::class, 'update'])->name('update');
        });
    });

    // LOGISTIC
    Route::prefix('logistic')->name('logistic.')->group(function () {

        // ITO - UPLOAD
        Route::prefix('ito-upload')->name('ito-upload.')->group(function () {
            Route::get('/data', [LogisticItoUploadController::class, 'data'])->name('data');
            Route::get('/', [LogisticItoUploadController::class, 'index'])->name('index');
            Route::post('/upload', [LogisticItoUploadController::class, 'upload'])->name('upload');
            Route::get('/addtodb', [LogisticItoUploadController::class, 'addtodb'])->name('addtodb');
            Route::get('/undo', [LogisticItoUploadController::class, 'undo'])->name('undo');
        });
        
        // ITO - MONITORING
        Route::prefix('ito-monitoring')->name('ito-monitoring.')->group(function () {
            Route::get('/data', [LogisticItoMonitoringController::class, 'data'])->name('data');
            Route::get('/', [LogisticItoMonitoringController::class, 'index'])->name('index');
            Route::post('/update', [LogisticItoMonitoringController::class, 'update'])->name('update');
            Route::post('/update-many', [LogisticItoMonitoringController::class, 'update_many'])->name('update_many');
            Route::get('/update-all', [LogisticItoMonitoringController::class, 'update_all'])->name('update_all');
        });

        Route::prefix('site-monitoring')->name('site-monitoring.')->group(function () {
            Route::get('/data', [LogisticSiteMonitoringController::class, 'data'])->name('data');
            Route::get('/', [LogisticSiteMonitoringController::class, 'index'])->name('index');
            Route::post('/update', [LogisticSiteMonitoringController::class, 'update'])->name('update');
            Route::post('/update-many', [LogisticSiteMonitoringController::class, 'update_many'])->name('update_many');
        });
    });

    Route::prefix('recaddoc')->name('recaddoc.')->group(function () {
        Route::put('/copied', [RecaddocController::class, 'copy_to_doktams'])->name('copy_to_doktams');
    });

    Route::prefix('accounting/dashboard')->name('dashboard.')->group(function () {
        Route::get('/index1', [InvoiceDashboardController::class, 'index1'])->name('index1');
        Route::get('/test', [InvoiceDashboardController::class, 'test'] );
    });

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DoktamDashboardController::class, 'index'])->name('index');
        Route::get('/test', [DoktamDashboardController::class, 'test'] );
    });

});

Route::get('/branch', [VendorbranchController::class, 'get_branch_by_vendor_id'])->name('get_branch');


















