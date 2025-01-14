<?php

use App\Http\Controllers\admin\LaporanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockManager;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\staffController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\settingsController;
use App\Http\Controllers\StokAdminController;
use App\Http\Controllers\Admin\userController;
use App\Http\Controllers\Admin\SuppliersController;
use App\Http\Controllers\Api\ApiTransactionController;
use App\Http\Controllers\Manager\LaporanController as ManagerLaporanController;
use App\Http\Controllers\verificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
    return redirect(route('login'));
});
Route::get('/test', function () {
    return view('example.index');
});

Route::group(['middleware' => ['auth','role:admin,manager,staff']], function () {
    Route::get('/email/verify',[verificationController::class,'index'] )->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}',[verificationController::class, 'verification'])->middleware(['signed'])->name('verification.verify');
    Route::get('/email/verification-notification',[verificationController::class, 'send_verification'])->middleware(['throttle:6,1'])->name('verification.send');;
});

Route::middleware('auth.token')->group(function () {
    Route::apiResource('stock-transaction', ApiTransactionController::class);
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk menampilkan form permintaan reset password (halaman email)
Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
// Route untuk mengirimkan email link reset password
Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
// Route untuk menampilkan form reset password (memerlukan token)
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
// Route untuk menangani form reset password dan memperbarui password
Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');

Route::group(['middleware' => ['auth', 'verified', 'role:admin,manager,staff']], function () {
    Route::get('/get_stock_for_chart', [AdminController::class, 'get_stock_for_chart'])->name('get_stock_for_chart');
    Route::get('/download/sample-import', [AdminController::class,'downloadSampleImport'])->name('download-sample-import');
    Route::get('/download/sample-opname', [AdminController::class,'downloadSampleImport'])->name('download-sample-opname');
    Route::get('/get-selected-id', [AdminController::class, 'getSelectedId']);
    Route::get('admin/simple-search', [AdminController::class, 'simpleSearch'])->name('simpleSearch');
    Route::post('/record-checkbox', [AdminController::class,'recordCheckbox']);
    Route::post('/change_paginate', [AdminController::class, 'changePaginate'])->name('change_paginate');
    Route::post('/filter-product', [AdminController::class, 'filterProduct'])->name('filter-product');
    Route::post('/import-product', [AdminController::class, 'importProduct'])->name('import-product');
    Route::post('/confirmImport-product', [AdminController::class, 'confirmImportProduct'])->name('confirmImport-product');
    Route::get('/export-product', [AdminController::class, 'exportProduct'])->name('export-product');
    Route::get('/export-product-selected', [AdminController::class, 'exportProductSelected'])->name('export-product-selected');

    // PRODUCT ROUTE =================================================================================================================================================
    Route::put('admin/product/data-produk/update/{id}', [AdminController::class, 'updateDataProduk'])->name('admin.product.data-produk.update');
    Route::post('admin/product/data-produk/add', [AdminController::class, 'newDataProduk'])->name('admin.product.data-produk.new');
    Route::delete('admin/product/data-produk/delete/{id}', [AdminController::class, 'deleteDataProduk'])->name('admin.product.data-produk.delete');
    Route::delete('admin/product/data-produk/delete-selected', [AdminController::class, 'deleteDataProdukSelected'])->name('admin.product.data-produk.delete-selected');

    // STOCK ROUTE =================================================================================================================================================
    Route::post('stok/filter-clear', [StokAdminController::class, 'clearAllFilter'])->name('admin.stok.filter.clear');
    Route::post('stok/filter', [StokAdminController::class, 'filterTransaction'])->name('admin.stok.filter');
    Route::get('stok/opname', [StokAdminController::class, 'opname'])->name('stockOpname');
    Route::get('stok/product-stock/opname-manual', [StokAdminController::class, 'productStokOpnameManual'])->name('admin.stok.productStok.opname-manual');
    Route::get('stok/product-stock/opname-withcsv', [StokAdminController::class, 'productStokOpnameCSV'])->name('admin.stok.productStok.opname-withcsv');
    Route::post('stok/product-stock/opname-withcsv', [StokAdminController::class, 'productStokOpnameCSV'])->name('admin.stok.productStok.opname-withcsv');
    Route::get('stok/product-stock/opname-riwayat', [StokAdminController::class, 'productStokOpnameRiwayat'])->name('admin.stok.productStok.opname-riwayat');
    Route::post('stok/product-stock/opname', [StokAdminController::class, 'productStokOpname'])->name('admin.stok.productStok.opname');
    Route::post('stok/product-stock/opname', [StokAdminController::class, 'productStokOpname'])->name('admin.stok.productStok.opname');
    Route::get('stok/product-stock/opname/{token}', [StokAdminController::class, 'productStokOpnameDetail'])->name('admin.stok.productStok.Detailopname');

    Route::get('admin/laporan/export-product-stock', [LaporanController::class, 'ExportProductStock'])->name('admin.laporan.ExportProductStock');
    Route::post('manager/laporan/filter', [ManagerLaporanController::class, 'stock_filter'])->name('manager.laporan.filter');   
});

Route::group(['middleware' => ['auth', 'verified', 'role:admin']], function () {

    Route::get('admin', [AdminController::class, 'index']);

    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('admin/product', [AdminController::class, 'product'])->name('admin.product');
    Route::get('admin/product/data-produk', [AdminController::class, 'dataProduk'])->name('admin.product.data-produk');

    Route::get('admin/product/categories-produk', [AdminController::class, 'categoriesProduk'])->name('admin.product.categories-produk');
    Route::post('admin/product/categories-produk/add', [AdminController::class, 'newCategoriesProduk'])->name('admin.product.categories-produk.add');
    Route::put('admin/product/categories-produk/update/{id}', [AdminController::class, 'updateCategoriesProduk'])->name('admin.product.categories-produk.update');
    Route::delete('admin/product/categories-produk/delete/{id}', [AdminController::class, 'deleteCategoriesProduk'])->name('admin.product.categories-produk.delete');

    Route::get('admin/stok', [StokAdminController::class, 'index'])->name('admin.stok');
    Route::get('admin/stok/product-stock', [StokAdminController::class, 'productStok'])->name('admin.stok.productStok');
    Route::post('admin/stok/product-stock/update-minimum-stock/{id}', [StokAdminController::class, 'updateMinimumStock'])->name('admin.stok.productStok.update-minimum-stock');
    Route::get('admin/stok/riwayat-transaksi', [StokAdminController::class, 'stokRiwayatTransaksi'])->name('admin.stok.riwayat-transaksi');

    Route::prefix('admin')->group(function () {
        Route::resource('supplier', SuppliersController::class)->names('admin.supplier');
    });
    Route::prefix('admin')->group(function () {
        Route::resource('users', userController::class)->names('admin.users');
    });
    
    Route::get('admin/laporan', [LaporanController::class , 'index'])->name('admin.laporan');
    Route::get('admin/laporan/export-user-activity', [LaporanController::class, 'ExportUserActivity'])->name('admin.laporan.ExportUserActivity');
    
    Route::get('admin/laporan/export-stock-transaction', [LaporanController::class, 'ExportStockTransaction'])->name('admin.laporan.ExportStockTransaction');
    Route::post('admin/laporan/session', [LaporanController::class , 'storeSession'])->name('admin.laporan.session');
    Route::prefix('admin')->group(function () {
        Route::resource('settings', settingsController::class)->names('admin.settings');
    });
});
Route::group(['middleware' => ['auth', 'verified', 'role:manager']], function () {

    Route::get('manager', [ManagerController::class, 'index']);

    Route::get('manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');

    Route::get('manager/product', [ManagerController::class, 'product'])->name('manager.product');

    Route::prefix('manager')->group(function () {
        Route::resource('stock', StockManager::class)->names('manager.stock');
    });

    Route::get('manager/supplier', [ManagerController::class, 'supplier'])->name('manager.supplier');

    Route::get('manager/laporan', [ManagerLaporanController::class, 'index'])->name('manager.laporan');

    Route::get('manager/laporan/export_barang_masuk', [ManagerLaporanController::class, 'export_barang_masuk'])->name('manager.laporan.export_in');
    Route::get('manager/laporan/export_barang_keluar', [ManagerLaporanController::class, 'export_barang_keluar'])->name('manager.laporan.export_out');
    

});
Route::group(['middleware' => ['auth', 'verified', 'role:staff']], function () {

    Route::get('staff', [staffController::class, 'index']);

    Route::get('staff/dashboard', [staffController::class, 'dashboard'])->name('staff.dashboard');

    Route::get('staff/stock', [staffController::class, 'stock'])->name('staff.stock');

    Route::post('staff/stock/confirm/{id}', [staffController::class, 'confirm_transaction'])->name('confirm_transation');

    Route::post('staff/stock/reject/{id}', [staffController::class, 'reject_transaction'])->name('reject_transaction');

});
