<?php

namespace App\Http\Controllers;

use App\Services\Product\ProductService;

class AdminController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function dashboard()
    {
        return view('adminpage.dashboard');
    }

    public function product()
    {
        $products = $this->productService->getProductPaginate(5);
        return view('adminpage.product', compact('products'));
    }

    public function stok()
    {
        return view('adminpage.stok');
    }

    public function suplier()
    {
        return view('adminpage.suplier');
    }

    public function pengguna()
    {
        return view('adminpage.pengguna');
    }

    public function laporan()
    {
        return view('adminpage.laporan');
    }

    public function settings()
    {
        return view('adminpage.settings');
    }

    public function dataProduk()
    {
        $products = $this->productService->getProductPaginate(5);
        return view('adminpage.product.data-product', compact('products'));
    }

    public function categoriesProduk()
    {
        return view('adminpage.product.categories-product');
    }

    public function attributeProduk()
    {
        return view('adminpage.product.attribute-product');
    }
}
