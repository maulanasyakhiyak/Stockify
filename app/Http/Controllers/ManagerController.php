<?php

namespace App\Http\Controllers;

use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\ProductStock\ProductStockRepository;
use App\Repositories\StockTransaction\StockTransactionRepository;
use App\Repositories\Supplier\SupplierRepository;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    protected $productPaginate = 10;

    protected $categoriesRepository;
    protected $productService;
    protected $supplierRepository;
    protected $productStockRepository;
    protected $stockTransactionRepository;

    public function __construct(SupplierRepository $supplierRepository,
                                CategoriesRepository $categoriesRepository,
                                ProductService $productService,
                                ProductStockRepository $productStockRepository,
                                StockTransactionRepository $stockTransactionRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
        $this->productService = $productService;
        $this->supplierRepository = $supplierRepository;
        $this->productStockRepository = $productStockRepository;
        $this->stockTransactionRepository = $stockTransactionRepository;
    }
    public function index(){
        return redirect(route('manager.dashboard'));
    }

    public function dashboard(){
        $low_stock = $this->productStockRepository->get_low_stock();
        $receive_today = $this->stockTransactionRepository->get_receive_today();
        $dispatched_today = $this->stockTransactionRepository->get_dispatched_today();
        return view('managerpage.dashboard', compact('low_stock','receive_today','dispatched_today'));
    }

    public function product(Request $req){
        $categories = $this->categoriesRepository->getCategories();
        $search = $req->get('search');

        $paginate = session('paginate', $this->productPaginate);
        $filter = session()->only(['category', 'selling_price_min', 'selling_price_max']);
        // dd($filter);
        if ($req->has('search')) {
            $products = $this->productService->getProductPaginate($paginate, $filter, $req->get('search'));
        } else {
            $products = $this->productService->getProductPaginate($paginate, $filter);
        }
        return view('managerpage.product', compact('categories','search','products','filter'));
    }

    public function stock(){
        return view('managerpage.stock');
    }

    public function supplier(Request $req){
        $search = null;
        if($req->has('search')){
            $search = $req->get('search');
            if( $req->get('search') == ''){
                return redirect()->route('manager.supplier');
            }
        }
        $suppliers = $this->supplierRepository->index(10, $search);
        return view('managerpage.supplier', compact('suppliers'));
    }

    public function pengguna(){
        return view('managerpage.dashboard');
    }


}
