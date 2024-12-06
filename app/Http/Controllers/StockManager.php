<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepository;
use App\Repositories\DetailOpname\DetailOpnameRepository;
use App\Repositories\ProductStock\ProductStockRepository;
use App\Services\StockTransaction\StockTransactionService;
use App\Repositories\RiwayatOpname\RiwayatOpnameRepository;
use App\Repositories\StockTransaction\StockTransactionRepository;

class StockManager extends Controller
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

    public function stock(Request $req){

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
        return view('managerpage.stock', compact('stockTransaction','earliestDate','filter'));
    }
}