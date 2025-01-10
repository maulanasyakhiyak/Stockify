<?php

namespace App\Http\Controllers\Manager;

use App\Exports\BarangKeluar;
use App\Exports\BarangMasuk;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\ProductStock\ProductStockRepository;
use App\Repositories\StockTransaction\StockTransactionRepository;

class LaporanController extends Controller
{
    protected $stockTransactionRepository;

    public function __construct(StockTransactionRepository $stockTransactionRepository){
        $this->stockTransactionRepository = $stockTransactionRepository; 
    }
    public function index(){
        $category =  Category::select('id', 'name')->get(); 
        $filter = session('filter_laporan_stock');
        $laporanStock = $this->stockTransactionRepository->laporanStokBarang();
        if($filter){
            $laporanStock = $this->stockTransactionRepository->laporanStokBarang(
                $filter['date_start'] ?? null,
                $filter['date_end'] ?? null,
                $filter['category'] ?? null,
            );
        }
        $data_filter = [
            'category' => isset($filter['category']) 
                ? optional($category->firstWhere('id', $filter['category']))->name 
                : null,
            'period' => isset($filter['date_start'], $filter['date_end']) 
                ? $filter['date_start'] . ' - ' . $filter['date_end'] 
                : null,
            'date_start' => $filter['date_start'] ?? null,
            'date_end' =>$filter['date_end'] ?? null
        ];

        $barang_masuk =  $this->stockTransactionRepository->laporan_barang_masuk_keluar('in');
        $barang_keluar =  $this->stockTransactionRepository->laporan_barang_masuk_keluar('out');
        return view('managerpage.laporan', compact('laporanStock','category','filter','data_filter','barang_masuk','barang_keluar'));
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

    public function export_barang_masuk(Request $request){
        $date = now()->format('d-m-Y');
        return Excel::download(new BarangMasuk($this->stockTransactionRepository), "export_barang_masuk-{$date}.xlsx");
    }
    public function export_barang_keluar(Request $request){
        $date = now()->format('d-m-Y');
        return Excel::download(new BarangKeluar($this->stockTransactionRepository), "export_barang_keluar-{$date}.xlsx");
    }
}
