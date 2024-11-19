<?php

namespace App\Http\Controllers;

use App\Models\ProductStockView;
use App\Repositories\StockTransaction\StockTransactionRepository;
use Exception;
use Illuminate\Http\Request;

class StokAdminController extends Controller
{
    protected $stokTransRepo;

    public function __construct(StockTransactionRepository $StockTransactionRepository)
    {
        $this->stokTransRepo = $StockTransactionRepository;
    }
    public function index(){
        return redirect()->route('admin.stok.riwayat-transaksi');
    }
    public function filterStock(Request $req){
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
        session()->forget('filterRiwayatTransaksi');
        return redirect()->back();
    }

    public function stokRiwayatTransaksi(){
        $stockTransaction = $this->stokTransRepo->getStockTransaction();
        $filter = session('filterRiwayatTransaksi');
        if($filter){
            $stockTransaction = $this->stokTransRepo->getStockTransaction(
            $filter['search'] ?? null,
            $filter['status'] ?? null,
            $filter['type'] ?? null,
            $filter['start'] ?? null,
            $filter['end'] ?? null
            );
        }else{
            $filter = [
                'search' => null,
                'status' => null,
                'type' => null,
                'start' => null,
                'end' => null
            ];
        }

        $earliestDate =  $this->stokTransRepo->getFirstDate();
        return view('adminpage.stok.riwayat-transaksi', compact('stockTransaction','earliestDate','filter'));
    }

    public function productStok(){
        $data = ProductStockView::all();
        return view('adminpage.stok.produk-stok', compact('data'));
    }


}
