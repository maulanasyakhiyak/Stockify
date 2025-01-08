<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Repositories\ProductStock\ProductStockRepository;
use App\Repositories\StockTransaction\StockTransactionRepository;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    protected $stockTransactionRepository;

    public function __construct(StockTransactionRepository $stockTransactionRepository){
        $this->stockTransactionRepository = $stockTransactionRepository; 
    }
    public function index(){
        $filter = session('filter_laporan_stock');
        $laporan = $this->stockTransactionRepository->laporanStokBarang();
        if($filter){
            $laporan = $this->stockTransactionRepository->laporanStokBarang(
                $filter['date_start'] ?? null,
                $filter['date_end'] ?? null,
                $filter['category'] ?? null,
            );
        }
        // dd($laporan);
        $productStock = $this->stockTransactionRepository->getStockTransaction('tahun');
        return view('managerpage.laporan', compact('productStock','laporan'));
    }
    public function stock_filter(Request $request){
        $filter = [
                'date_start' => $request->input('start') ?? null,
                'date_end' => $request->input('end') ?? null,
                'category' => $request->input('category') ?? null,
        ];
        $filtered = array_filter($filter, function ($value) {
            return !is_null($value) && $value !== '';
        });
        if (empty($filtered)) {
            session()->forget('filter_laporan_stock');
            return redirect()->back();
        }
        session(['filter_laporan_stock' => $filtered]);
    
        return redirect()->back();
    }
}
