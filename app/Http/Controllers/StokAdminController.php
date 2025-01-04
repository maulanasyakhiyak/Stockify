<?php

namespace App\Http\Controllers;

use App\Imports\stockOpname;
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
use Maatwebsite\Excel\Facades\Excel;

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
            session([$req->input('route') => $riwayatTransaksiFilter]);
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

    public function clearAllFilter(Request $req){
        $previousUrl = strtok(url()->previous(), '?');
        // switch($previousUrl){
        //     case route('admin.stok.riwayat-transaksi'):
                session()->forget('/'.$req->input('route'));
        //         break;
        //     case route('admin.stok.productStok'):
        //         break;
        // }
        return redirect()->back();
    }

    public function filterStock(Request $req){

    }
    // ====================================================================== FILTER END

    public function stokRiwayatTransaksi(Request $req){
        $stockTransaction = $this->stokTransRepo->getStockTransaction();
        $filter = session('/'.$req->path());
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

    public function opname(){
        $url = url()->previous();
        if (session('previous_url_opname') !== $url) {
            session(['previous_url_opname' => $url]);
        }
        return redirect()->route('admin.stok.productStok.opname-manual');
    }

    public function productStokOpname(Request $req){
        if($req->has('data') && $req->has('keterangan')){
            // return response()->json([
            //     'status' => 'debuging',
            //     'message' => $req->all(),
            // ]);
            $data = $req->input('data');
            try{
                $token = $this->stockTransactionService->stockOpname($data, $req->input('keterangan'));
                return response()->json([
                    'status' => 'success',
                    'data' => $data,
                    'url' => route('admin.stok.productStok.Detailopname',$token)
                ]);
            }catch(Exception $e){
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
                ]);
            }

        }else{

        }
    }

    public function productStokOpnameManual(){
        return view('adminpage.stok.stock-opname-manual');
    }
    public function productStokOpnameCSV(Request $req){
        if($req->has('file-opname-csv')){
            if(!$req->file('file-opname-csv')){
                return response()->json([
                    'status' => 'error',
                    'message' => 'file not found'
                    ]);
            }
            try{
                $import = new stockOpname;
                Excel::import($import, $req->file('file-opname-csv'));
                $data = $import->getProducts();
                return response()->json([
                    'status' => 'success',
                    'message' => 'success',
                    'data' => $data
                ]);
            }catch(Exception $e){
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ]);

            }
        }
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
