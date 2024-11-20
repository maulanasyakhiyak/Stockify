<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\ApiTransactionController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StokAdminController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth.token')->group(function () {
    Route::apiResource('stock-transaction', ApiTransactionController::class);
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin', function () {
        return redirect(route('admin.dashboard'));
    });
    Route::get('admin/simple-search', [AdminController::class, 'simpleSearch'])->name('simpleSearch');
    Route::get('/get-selected-id', [AdminController::class,'getSelectedId']);
    Route::post('/record-checkbox', [AdminController::class,'recordCheckbox']);
    Route::post('/change_paginate', [AdminController::class, 'changePaginate'])->name('change_paginate');
    Route::post('/filter-product', [AdminController::class, 'filterProduct'])->name('filter-product');
    Route::post('/import-product', [AdminController::class, 'importProduct'])->name('import-product');
    Route::post('/confirmImport-product', [AdminController::class, 'confirmImportProduct'])->name('confirmImport-product');
    Route::get('/export-product', [AdminController::class, 'exportProduct'])->name('export-product');
    Route::get('/export-product-selected', [AdminController::class, 'exportProductSelected'])->name('export-product-selected');

    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('admin/product', [AdminController::class, 'product'])->name('admin.product');
    Route::get('admin/product/data-produk', [AdminController::class, 'dataProduk'])->name('admin.product.data-produk');
    Route::post('admin/product/data-produk/add', [AdminController::class, 'newDataProduk'])->name('admin.product.data-produk.new');
    Route::put('admin/product/data-produk/update/{id}', [AdminController::class, 'updateDataProduk'])->name('admin.product.data-produk.update');
    Route::delete('admin/product/data-produk/delete/{id}', [AdminController::class, 'deleteDataProduk'])->name('admin.product.data-produk.delete');
    Route::delete('admin/product/data-produk/delete-selected', [AdminController::class, 'deleteDataProdukSelected'])->name('admin.product.data-produk.delete-selected');

    Route::get('admin/product/categories-produk', [AdminController::class, 'categoriesProduk'])->name('admin.product.categories-produk');
    Route::post('admin/product/categories-produk/add', [AdminController::class, 'newCategoriesProduk'])->name('admin.product.categories-produk.add');
    Route::put('admin/product/categories-produk/update/{id}', [AdminController::class, 'updateCategoriesProduk'])->name('admin.product.categories-produk.update');
    Route::delete('admin/product/categories-produk/delete/{id}', [AdminController::class, 'deleteCategoriesProduk'])->name('admin.product.categories-produk.delete');

    Route::get('admin/product/attribute-produk', [AdminController::class, 'attributeProduk'])->name('admin.product.attribute-produk');

    Route::post('admin/stok/filter-clear', [StokAdminController::class, 'clearAllFilter'])->name('admin.stok.filter.clear');
    Route::post('admin/stok/filter', [StokAdminController::class, 'filterTransaction'])->name('admin.stok.filter');
    Route::get('admin/stok', [StokAdminController::class, 'index'])->name('admin.stok');
    Route::get('admin/stok/product-stock', [StokAdminController::class, 'productStok'])->name('admin.stok.productStok');
    Route::get('admin/stok/riwayat-transaksi', [StokAdminController::class, 'stokRiwayatTransaksi'])->name('admin.stok.riwayat-transaksi');

    Route::get('admin/suplier', [AdminController::class, 'suplier'])->name('admin.suplier');
    Route::get('admin/pengguna', [AdminController::class, 'pengguna'])->name('admin.pengguna');
    Route::get('admin/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    Route::get('admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
});
