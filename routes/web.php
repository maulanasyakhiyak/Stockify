<?php

use App\Http\Controllers\AdminController;
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
    return view('welcome');
})->name('a');

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::get('/product', [AdminController::class, 'product'])->name('admin.product');
Route::get('/product/data-produk', [AdminController::class, 'dataProduk'])->name('admin.product.data-produk');
Route::post('/product/data-produk/add', [AdminController::class, 'newDataProduk'])->name('admin.product.data-produk.new');
Route::get('/product/categories-produk', [AdminController::class, 'categoriesProduk'])->name('admin.product.categories-produk');
Route::get('/product/attribute-produk', [AdminController::class, 'attributeProduk'])->name('admin.product.attribute-produk');

Route::get('/product/data-produk', [AdminController::class, 'dataProduk'])->name('admin.product.data-produk');
Route::get('/stok', [AdminController::class, 'stok'])->name('admin.stok');
Route::get('/suplier', [AdminController::class, 'suplier'])->name('admin.suplier');
Route::get('/pengguna', [AdminController::class, 'pengguna'])->name('admin.pengguna');
Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
