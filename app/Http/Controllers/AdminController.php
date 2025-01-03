<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
use App\Models\StockTransaction;
use App\Events\UserActivityLogged;
use App\Models\UserActivityLog;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Services\Product\ProductService;
use App\Services\Categories\CategoriesService;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Supplier\SupplierRepository;
use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\StockTransaction\StockTransactionRepository;
use App\Repositories\UserActivity\UserActivityRepository;

class AdminController extends Controller
{
    protected $productPaginate = 10;

    protected $categoriesPaginate = 10;

    protected $checkboxSession;

    protected $productService;

    protected $categoriesService;

    protected $categoriesRepository;

    protected $productRepository;

    protected $supplierRepository;

    protected $stockTransactionRepository;
    
    protected $userActivityRepository;

    public function __construct(
        StockTransactionRepository $stockTransactionRepository,
        ProductRepository $productRepository,
        ProductService $productService,
        CategoriesService $categoriesService,
        CategoriesRepository $categoriesRepository,
        SupplierRepository $supplierRepository,
        UserActivityRepository $userActivityRepository
    ) {
        $this->stockTransactionRepository = $stockTransactionRepository;
        $this->productService = $productService;
        $this->productRepository = $productRepository;
        $this->categoriesService = $categoriesService;
        $this->categoriesRepository = $categoriesRepository;
        $this->supplierRepository = $supplierRepository;
        $this->userActivityRepository = $userActivityRepository;
        $this->checkboxSession = session('checkbox', []);
    }

    public function index()
    {
        return redirect(route('admin.dashboard'));
    }

    public function simpleSearch(Request $req)
    {
        $encryptedTable = $req->get('table');
        $term = $req->get('term');
        $by = $req->get('search') ?? 'name';
        $tables = [
            '2c6ee24b09816a6f14f95d1698b24ead' => 'users',   // Misalnya, 'table_1' adalah nama tabel yang diizinkan
            '2d2d2c4b9e1d2f6f2bcd345b223ee6d4' => 'product',
        ];

        if (is_array($encryptedTable)) {

            foreach ($encryptedTable as $item) {
                if (isset($tables[$item])) {

                    switch ($tables[$item]) {
                        case 'users':
                            $user = User::where('name', 'like', "%{$term}%")->get();
                            break;
                        case 'product':
                            $product = Product::where($by, 'like', "%{$term}%")->get();
                            break;
                    }
                }
            }
            return response()->json([
                'user' => $user,
                'product' => $product,
            ]);
        } else {
            if (array_key_exists($encryptedTable, $tables)) {
                switch ($encryptedTable) {
                    case '2c6ee24b09816a6f14f95d1698b24ead':
                        $data = User::where('name', 'like', "%{$term}%")->get();
                        break;
                    case '2d2d2c4b9e1d2f6f2bcd345b223ee6d4':
                        $data = Product::where($by, 'like', "%{$term}%")->get();
                        break;
                }
                return response()->json([
                    'data' => $data
                ]);
            } else {
                return response()->json(['error' => 'Invalid table'], 400);
            }
        }
    }

    public function dashboard()
    {
        $user_activity = UserActivityLog::get();

        // dd($user_activity);
        $total_transaksi_masuk = $this->stockTransactionRepository->get_total_transaction('in');
        $total_transaksi_keluar = $this->stockTransactionRepository->get_total_transaction('out');
        $total_product = $this->productRepository->sumProduct();
        // dd($total_transaksi_keluar);
        return view('adminpage.dashboard', compact('total_product','total_transaksi_masuk','total_transaksi_keluar','user_activity'));
    }

    public function get_stock_for_chart(Request $req)
    {
        $range = $req->get('params');
        try{
            $data = $this->stockTransactionRepository->get_stock_for_chart($range);

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }catch (Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage() . $e->getLine()
            ]);
        }

    }

    public function product()
    {
        return redirect()->route('admin.product.data-produk');
    }

    // PRODUCT FUNCTION
    public function getSelectedId(Request $req)
    {
        $data = session('checkbox', []);
        if ($req->has('withData')) {
            $data_product = $this->productRepository->findMultipleProduct($data);
            return response()->json([
                'success' => true,
                'data' => $data_product,
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => count($data),
            ]);
        }
    }

    public function importProduct(Request $req)
    {


        if ($req->has('addNewCategory')) {

            try {
                $categories = $req->input('newCategory');
                if (is_string($categories)) {
                    $categories = json_decode($categories, true);
                }
                $categoryData = array_map(function ($categoryName) {
                    return ['name' => $categoryName, 'description' => 'no desc'];
                }, $categories);
                $this->categoriesRepository->createCategories($categoryData);
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'fail',
                    'error' => $e->getMessage()
                ]);
            }
        }
        if (!$req->file('file')) {
            $file = Cache::get('importTemp' . auth()->id());
        } else {
            $file = $req->file('file');
        }
        try {


            $import = new ProductImport;
            Excel::import($import, $file);
            $newCategories = $import->getNewCategories();

            // if($file == $file_cache){
            //     Cache::forget('importTemp' . auth()->id());
            //     Storage::delete($file);
            // }

            if (!empty($newCategories)) {
                $filePath = $req->file('file')->store('temp_uploads');

                Cache::put('importTemp' . auth()->id(), $filePath, now()->addMinutes(30));
                return response()->json([
                    'status' => 'pending',
                    'newCategory' => $newCategories
                ]);
            }
            event(new UserActivityLogged(auth()->id(), 'import', "importing data product, added {$import->added} updated and {$import->updated} data"));
            return response()->json([
                'status' => 'success',
                'added' => $import->added,
                'updated' => $import->updated,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'error' => $e->getMessage() . ',on ' . $e->getFile() . ', at ' . $e->getLine(),
                'message' => $e->getMessage()
            ]);
        }
    }

    public function exportProduct()
    {
        $date = now()->format('Y-m-d');
        return Excel::download(new ProductExport, "products-{$date}.xlsx");
    }

    public function exportProductSelected()
    {
        $selectedData = session('checkbox', []);
        $date = now()->format('Y-m-d');
        if (empty($selectedData)) {
            return back()->with('error', 'Tidak ada produk yang dipilih untuk diekspor.');
        }
        return Excel::download(new ProductExport($selectedData), "products-{$date}.xlsx");
    }

    public function recordCheckbox(Request $req)
    {
        $checkboxSession = session()->get('checkbox', []);
        try {
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
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
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

    public function searchProduct(Request $req)
    {
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
        $paginate = session('paginate', $this->productPaginate);
        $filter = session()->only(['category', 'selling_price_min', 'selling_price_max']);
        $categories = $this->categoriesRepository->getCategories();

        if ($req->has('search')) {
            $products = $this->productService->getProductPaginate($paginate, $filter, $req->get('search'));
        } else {
            $products = $this->productService->getProductPaginate($paginate, $filter);
        }

        $search = $req->get('search');
        $page = $req->get('page', 1);

        if ($page > $products->lastPage()) {
            return redirect()->route('admin.product.data-produk');
        }

        return view('adminpage.product.data-product', compact(
            'products',
            'categories',
            'paginate',
            'search',
            'page',
            'filter',
        ));
    }

    public function newDataProduk(Request $r)
    {
        $result = $this->productService->createProduct([
            'name' => $r->input('name'),
            'atributes' => $r->input('atributes'),
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
            'atributes' => $req->input('atributes'),
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

    public function pengguna()
    {
        return view('adminpage.pengguna');
    }

    public function laporan()
    {
        return view('adminpage.laporan');
    }

    // .CATEGORY

    public function categoriesProduk(Request $req)
    {
        $paginate = session('paginate', $this->categoriesPaginate);
        if ($req->has('categorySearch')) {
            $categories = $this->categoriesRepository->getCategories($paginate, $req->get('categorySearch'));
        } else {
            $categories = $this->categoriesRepository->getCategories($paginate);
        }
        $search = $req->get('categorySearch');
        return view('adminpage.product.categories-product', compact('categories', 'paginate', 'search'));
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

    // Download
    public function downloadSampleImport()
    {

        $routeName = request()->route()->getName();

        if ($routeName === 'download-sample-import') {
            $filePath = storage_path('app/private/sample_import.xlsx');
        } else {
            $filePath = storage_path('app/private/sample_opname.xlsx');
        }

        // Pastikan file ada sebelum di-download
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath);
    }
}
