<?php

namespace App\Http\Controllers;

use App\Repositories\Categories\CategoriesRepository;
use App\Services\Categories\CategoriesService;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $productService;

    protected $categoriesService;

    public function __construct(ProductService $productService, CategoriesService $categoriesService)
    {
        $this->productService = $productService;
        $this->categoriesService = $categoriesService;
    }

    public function dashboard()
    {
        return view('adminpage.dashboard');
    }

    // PRODUCT FUNCTION
    public function product()
    {
        $products = $this->productService->getProductPaginate(5);

        return view('adminpage.product', compact('products'));
    }

    public function dataProduk()
    {
        $products = $this->productService->getProductPaginate(5);

        return view('adminpage.product.data-product', compact('products'));
    }

    public function newDataProduk(Request $r)
    {

        $result = $this->productService->createProduct([
            'name' => $r->input('name'),
            'category' => $r->input('category'),
            'stock' => $r->input('product_stock'),
            'purchase_price' => $r->input('purchase_price'),
            'sale_price' => $r->input('selling_price'),
            'description' => $r->input('desc'),
        ]);

        if ($result['success']) {
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('openDrawer', true)->withErrors($result['error']);
        }
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

    public function categoriesProduk()
    {
        return view('adminpage.product.categories-product');
    }

    public function newCategoriesProduk(Request $req)
    {
        $result = $this->categoriesService->createCategories($req->all());

        if ($result['success']) {
            return redirect()->back()->with('success', 'Category berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('openDrawer', true)->with('error', $result['error']);
        }
    }

    public function updateCategoriesProduk(Request $req, $id)
    {
        $result = $this->categoriesService->updateCategories($id, [
            'name' => $req->input('name'),
            'description' => $req->input('desc'),
        ]);

        if ($result['success']) {
            return redirect()->back()->with('success', 'Category berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('openDrawer', true)->with('error', $result['error']);
        }
    }

    public function attributeProduk()
    {
        return view('adminpage.product.attribute-product');
    }

    public function deleteCategoriesProduk(CategoriesRepository $categoriesRepository, $id)
    {
        $result = $categoriesRepository->deleteCategories($id);
        if ($result) {
            return redirect()->back()->with('success', 'Category berhasil dihapus!');
        } else {
            return redirect()->back()->withInput()->with('openDrawer', true)->with('error',
                $result['error']);
        }

    }
}
