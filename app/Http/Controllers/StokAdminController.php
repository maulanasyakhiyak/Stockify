<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductStockView;
use App\Models\StockTransaction;
use App\Repositories\DetailOpname\DetailOpnameRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductStock\ProductStockRepository;
use App\Repositories\RiwayatOpname\RiwayatOpnameRepository;
use App\Repositories\StockTransaction\StockTransactionRepository;
use App\Services\StockTransaction\StockTransactionService;
use Exception;
use Illuminate\Http\Request;

class StokAdminController extends Controller
{
    protected $stokTransRepo;
    protected $stockTransactionService;
    protected $productStockRepository;
    protected $productRepository;
    protected $riwayatOpnameRepository;
    protected $detailOpnameRepository;

    public function __construct(StockTransactionRepository $StockTransactionRepository,
                                StockTransactionService $stockTransactionService,
                                ProductStockRepository $productStockRepository,
                                ProductRepository $productRepository,
                                DetailOpnameRepository $detailOpnameRepository,
                                RiwayatOpnameRepository $riwayatOpnameRepository
                                )
    {
        $this->stockTransactionService = $stockTransactionService;
        $this->stokTransRepo = $StockTransactionRepository;
        $this->productStockRepository = $productStockRepository;
        $this->productRepository = $productRepository;
        $this->detailOpnameRepository = $detailOpnameRepository;
        $this->riwayatOpnameRepository = $riwayatOpnameRepository;
        
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

    public function productStokOpname(Request $req){
        if($req->has('data')){

            $data = $req->input('data');
            try{
                $token = $this->stockTransactionService->stockOpname($data);
                return response()->json([
                    'status' => 'success',
                    'data' => $data,
                    'url' => route('admin.stok.productStok.Riwayatopname',$token)
                ]);
            }catch(Exception $e){
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ]);
            }

        }else{
            
        }
    }

    public function productStokOpnameManual(){
        return view('adminpage.stok.stock-opname-manual');
    }
    public function productStokOpnameCSV(){
        return view('adminpage.stok.stock-opname-csv');
    }
    public function productStokOpnameRiwayat(){
        $riwayat = $this->riwayatOpnameRepository->RiwayatAll();
        return view('adminpage.stok.stock-opname-riwayat', compact('riwayat'));
    }

    public function productStokOpnameDetail($token){
        $data=$this->detailOpnameRepository->getDataByToken($token);
        if(!$data){
            return abort(404);
        }
        // dd($data->detailOpnames->first()->product->name);
        return view('adminpage.stok.detail-stock-opname',compact('data'));
    }

}
