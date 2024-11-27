<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductStockView;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductStock\ProductStockRepository;
use App\Repositories\StockTransaction\StockTransactionRepository;
use Exception;
use Illuminate\Http\Request;

class StokAdminController extends Controller
{
    protected $stokTransRepo;
    protected $productStockRepository;
    protected $productRepository;

    public function __construct(StockTransactionRepository $StockTransactionRepository,
                                ProductStockRepository $productStockRepository,
                                ProductRepository $productRepository
                                )
    {
        $this->stokTransRepo = $StockTransactionRepository;
        $this->productStockRepository = $productStockRepository;
        $this->productRepository = $productRepository;
    }
    public function index(){
        return redirect()->route('admin.stok.riwayat-transaksi');
    }
    // ====================================================================== FILTER
    public function filterTransaction(Request $req){
        $riwayatTransaksiFilter = [
            'search' => $req->input('filterSearch'),
            'status' => $req->input('status'),
            'type' => $req->input('type'),
            'start' => $req->input('dateRangeStart'),
            'end' => $req->input('dateRangeEnd'),
        ];
        try{
            session(['filterRiwayatTransaksi' => $riwayatTransaksiFilter]);
            return response()->json([
                'status' => 'success'
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ]);
        }

    }
    public function clearAllFilter(){
        $previousUrl = strtok(url()->previous(), '?');
        switch($previousUrl){
            case route('admin.stok.riwayat-transaksi'):
                session()->forget('filterRiwayatTransaksi');
                break;
            case route('admin.stok.productStok'):
                break;
        }
        return redirect()->back();
    }

    public function filterStock(Request $req){

    }
    // ====================================================================== FILTER END

    public function stokRiwayatTransaksi(Request $req){
        $stockTransaction = $this->stokTransRepo->getStockTransaction();
        $filter = session('filterRiwayatTransaksi');
        if($filter || $req->has('search')){
            $stockTransaction = $this->stokTransRepo->getStockTransaction(
            $filter['search'] ?? null,
            $filter['status'] ?? null,
            $filter['type'] ?? null,
            $filter['start'] ?? null,
            $filter['end'] ?? null,
            $req->get('search') ?? null,
            );
        }else{
            $filter = [
                'search' => null,
                'status' => null,
                'type' => null,
                'start' => null,
                'end' => null,
                $req->get('search') ?? null,
            ];
        }
        // dd($filter);

        $earliestDate =  $this->stokTransRepo->getFirstDate();
        return view('adminpage.stok.riwayat-transaksi', compact('stockTransaction','earliestDate','filter'));
    }

    public function productStok(Request $r){
        $productStock = $this->productStockRepository->getAll(null,10);
        if($r->has('search')){
            if($r->get('search') == ''){
                return redirect()->route('admin.stok.productStok');
            }
            $productStock = $this->productStockRepository->getAll($r->get('search'),10);
        }
        return view('adminpage.stok.produk-stok', compact('productStock'));
    }

    public function updateMinimumStock(Request $r){
        $data = [
            'minimal_stock' => $r->input('stock')
        ];
        $id = $r->input('id');
        try{
            $result = $this->productRepository->updateProduct($data,$id);
            // dd($result);
            return response()->json([
                'status' => 'success',
                'result' => $result
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ]);
        }

    }

    public function productStokOpname(){
        return view('adminpage.stok.stock-opname');
    }


}
