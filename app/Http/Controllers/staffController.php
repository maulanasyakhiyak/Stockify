<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\UserActivityLogged;
use App\Repositories\Product\ProductRepository;
use App\Repositories\DetailOpname\DetailOpnameRepository;
use App\Repositories\ProductStock\ProductStockRepository;
use App\Services\StockTransaction\StockTransactionService;
use App\Repositories\RiwayatOpname\RiwayatOpnameRepository;
use App\Repositories\StockTransaction\StockTransactionRepository;

class staffController extends Controller
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
        return redirect()->route('staff.dashboard');
    }

    public function dashboard(){
    return view('staffpage.dashboard');
    }

    public function stock(Request $req){

    $stockTransaction = $this->stokTransRepo->getStockTransaction();
    $filter = session('filterRiwayatTransaksi');
    // dd($filter);
    if($filter || $req->has('search')){
        $stockTransaction = $this->stokTransRepo->getStockTransaction(
        $filter['search'] ?? null,
        $filter['status'] ?? null,
        $filter['type'] ?? null,
        $filter['start'] ?? null,
        $filter['end'] ?? null,
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
    // dd($stockTransaction);

    $earliestDate =  $this->stokTransRepo->getFirstDate();
    return view('staffpage.stock', compact('stockTransaction','earliestDate','filter'));
    }

    public function confirm_transation(Request $request, $id){
        event(new UserActivityLogged(auth()->id(), 'confirm', "accepting new transaction with id : {$id}"));
        $data = $this->stokTransRepo->update($id,[
            'status' => 'completed'
        ]);
        // dd($data);
        return redirect()->back()->with('success', 'Berhasil konfirmasi transaksi');
    }
    
    public function reject_transaction(Request $request, $id){
        event(new UserActivityLogged(auth()->id(), 'reject', "rejecting new transaction with id : {$id}"));
        $this->stokTransRepo->update($id,[
            'status' => 'cancelled'
        ]);
        return redirect()->back()->with('success', 'Berhasil menolak transaksi');
    }

}
