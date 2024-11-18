<?php

namespace App\Http\Controllers;

use App\Repositories\StockTransaction\StockTransactionRepository;
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
    public function stokRiwayatTransaksi(){
        $stockTransaction = $this->stokTransRepo->getStockTransaction();
        return view('adminpage.stok.riwayat-transaksi', compact('stockTransaction'));
    }
}
