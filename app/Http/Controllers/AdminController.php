<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Product\ProductService;
use App\Services\Categories\CategoriesService;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Categories\CategoriesRepository;

class AdminController extends Controller
{
    protected $paginate = 10;

    protected $checkboxSession;

    protected $productService;

    protected $categoriesService;

    protected $categoriesRepository;

    protected $productRepository;

    public function __construct(ProductRepository $productRepository,
                                ProductService $productService,
                                CategoriesService $categoriesService,
                                CategoriesRepository $categoriesRepository)
    {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
        $this->categoriesService = $categoriesService;
        $this->categoriesRepository = $categoriesRepository;
        $this->checkboxSession = session('checkbox', []);
    }

    public function dashboard()
    {
        return view('adminpage.dashboard');
    }

    // PRODUCT FUNCTION
    public function getSelectedId(Request $req)
    {
        $data = session('checkbox', []);
        if($req->has('withData')){
            $data_product = $this->productRepository->findMultipleProduct($data);
            return response()->json([
                'success' => true,
                'data' => $data_product,
            ]);
        }else{
            return response()->json([
                'success' => true,
                'data' => count($data),
            ]);
        }


    }

    public function importProduct(Request $req){
        try{
            $file = $req->file('file');
            Excel::import(new ProductImport, $file);
            $name = $file->getClientOriginalName();
            return response()->json([
                'success' => true,
                'data' => $name
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    
    }

    public function recordCheckbox(Request $req)
    {
        $checkboxSession = session()->get('checkbox', []);
        try{
            if ($req->has('checkedItems')) {
                $checkedItems = ($req->input('checkedItems'));
                foreach ($checkedItems as  $item) {
                    if (!in_array($item, $checkboxSession)) {
                        $checkboxSession[] =  (int)$item;
                    }
                }
            }
            if ($req->has('uncheckedItems')) {
                $uncheckedItems = $req->input('uncheckedItems');
                    foreach ($uncheckedItems as $item) {
                        $key = array_search((int)$item, $checkboxSession);
                        if ($key !== false) {
                            unset($checkboxSession[$key]);
                        }
                    }
            }

            session(['checkbox' => $checkboxSession]);
            return response()->json(['success' => true]);
        }catch(Exception $e){
            return response()->json(['success' => false , 'message' => $e->getMessage()]);
        }

    }

    public function changePaginate(Request $req)
    {
        session(['paginate' => $req->input('paginate_change')]);

        return response()->json(['success' => true]);
    }

    public function filterProduct(Request $req)
    {

        $filter = [
            'category' => $req->input('category_filter'),
            'selling_price_min' => $req->input('selling_price_min'),
            'selling_price_max' => $req->input('selling_price_max'),

        ];

        session($filter);

        return response()->json(['success' => true]);
    }

    public function searchProduct(Request $req){
        $val = $req->input('input');
        $productsSearch = $this->productRepository->searchProduct($val, 5);
        $categoriesSearch = $this->categoriesRepository->getCategories();

        $html = view('components.tables.admin.product.table-product', [
            'products' => $productsSearch,
            'categories' => $categoriesSearch,
            'routeUpdate' => 'admin.product.data-produk.update',
            'routeDelete' => 'admin.product.data-produk.delete'
        ])->render();

        return response()->json([
            'status' => 'success',
            'data' => $html
        ]);
    }

    public function dataProduk(Request $req)
    {
        // dd(session()->all());
        $paginate = session('paginate', $this->paginate);
        $filter = session()->only(['category', 'selling_price_min', 'selling_price_max']);
        $categories = $this->categoriesRepository->getCategories();

        if($req->has('search')){
            $products = $this->productService->getProductPaginate($paginate,$filter, $req->get('search'));
        }else{
            $products = $this->productService->getProductPaginate($paginate, $filter);
        }

        $search = $req->get('search');
        $page = $req->get('page');

        if ($page > $products->lastPage()) {
            return redirect()->route('admin.product.data-produk');
        }

        return view('adminpage.product.data-product', compact(
            'products',
            'categories',
            'paginate',
            'search',
            'filter' ,
            ));
    }

    public function newDataProduk(Request $r)
    {

        $result = $this->productService->createProduct([
            'name' => $r->input('name'),
            'image' => $r->file('product_image'),
            'category_id' => $r->input('category'),
            'sku' => $r->input('product_stock'),
            'purchase_price' => $r->input('purchase_price'),
            'selling_price' => $r->input('selling_price'),
            'description' => $r->input('desc'),
        ]);

        if ($result['success']) {
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('openDrawer', true)->withErrors($result['message']);
        }
    }

    public function deleteDataProduk($id)
    {
        $checkboxSession = session('checkbox', []);
        unset($checkboxSession[$id]);
        session(['checkbox' => $checkboxSession]);
        $result = $this->productService->deleteProduct($id);

        return redirect()->back()->with(
            $result['success'] ? 'success' : 'error',
            $result['message']
        );
    }

    public function deleteDataProdukSelected()
    {
        $data_selected = session('checkbox', []);
        $this->productRepository->destroyProduct($data_selected);
        session()->forget('checkbox');

        return redirect()->back()->with('success', 'Data berhasil dihapus');

    }
    public function updateDataProduk(Request $req, $id)
    {
        $result = $this->productService->serviceUpdateProduct([
            'name' => $req->input('name'),
            'image' => $req->file('product_update_image_' . $id),
            'category_id' => $req->input('category-update'),
            'sku' => $req->input('sku'),
            'purchase_price' => $req->input('purchase_price'),
            'selling_price' => $req->input('selling_price'),
            'description' => $req->input('description'),
        ], $id);

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        } else {
            return redirect()->back()->withInput()->with('openDrawer', true)->withErrors($result['message']);
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
        $paginate = session('paginate', $this->paginate);
        $categories = $this->categoriesRepository->getCategories($paginate);
        return view('adminpage.product.categories-product', compact('categories', 'paginate'));
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
            'description' => $req->input('description'),
        ]);

        if ($result['success']) {
            return redirect()->back()->with('success', 'Category berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->withErrors($result['message']);
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
            return redirect()->back()->withInput()->with('openDrawer', true)->with(
                'error',
                $result['error']
            );
        }
    }
}
