<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\ProductStock;
use App\Exports\UserActivity;
use App\Exports\StockTransaction;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\UserActivity\UserActivityService;
use App\Repositories\ProductStock\ProductStockRepository;
use App\Repositories\UserActivity\UserActivityRepository;
use App\Repositories\StockTransaction\StockTransactionRepository;

class LaporanController extends Controller{
    protected $userActivityRepository;
    protected $userActivityService;
    protected $stockTransactionRepository;
    protected $productStockRepository;

    public function __construct(UserActivityRepository $userActivityRepository,
                                UserActivityService $userActivityService,
                                StockTransactionRepository $stockTransactionRepository,
                                ProductStockRepository $productStockRepository) {
        $this->userActivityRepository = $userActivityRepository;
        $this->userActivityService = $userActivityService;
        $this->stockTransactionRepository = $stockTransactionRepository;
        $this->productStockRepository = $productStockRepository;
    }

    public function storeSession(Request $request){
        session(['activity' =>  [
                                'range'     =>  $request->input('range') ?? null
                                ]
        ]);
        return redirect()->back();
    }

    public function index(Request $request){
        $user_activity = $this->userActivityService->getActivities(session('activity')['range'] ?? '1 month');
        $category =  Category::select('id', 'name')->get(); 
        // GET PRODUCT STOCK
        $filter = session('filter_laporan_stock');
        $laporan_stock = $this->stockTransactionRepository->laporanStokBarang();
        if($filter){
            $laporan_stock = $this->stockTransactionRepository->laporanStokBarang(
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
        ];

        // GET STOCK TRANSACTION
        $stockTransaction = $this->stockTransactionRepository->getStockTransaction();
        $filter_transaction = session('/'.$request->path());
        if($filter_transaction || $request->has('search')){
            $stockTransaction = $this->stockTransactionRepository->getStockTransaction(
            $filter_transaction['search'] ?? null,
            $filter_transaction['status'] ?? null,
            $filter_transaction['type'] ?? null,
            $filter_transaction['start'] ?? null,
            $filter_transaction['end'] ?? null,
            );
        }
        $earliestDate =  $this->stockTransactionRepository->getFirstDate();
        return view('adminpage.laporan', compact(
            'user_activity',
            'stockTransaction',
            'earliestDate',
            'filter_transaction',
            'data_filter',
            'laporan_stock',
            'category'
        ));
    }

    public function ExportUserActivity(){
        $date = now()->format('Y-m-d');
        $timeRange = session('activity')['range'];
        return Excel::download(new UserActivity($timeRange), "UserActivity-{$date}.xlsx");
    }
    
    public function ExportProductStock(){
        $date = now()->format('Y-m-d');
        $filter = session('filter_laporan_stock');
        return Excel::download(new ProductStock([
            'start_date' => $filter['date_start'] ?? null,
            'end_date' => $filter['date_end'] ?? null,
            'category' => $filter['category'] ?? null,
        ],$this->stockTransactionRepository), "ExportProductStock-{$date}.xlsx");
    }

    public function ExportStockTransaction(Request $request) {
        $date = now()->format('Y-m-d');
        $filter = session('/'.$request->input('url'));
        // dd($filter);
        $stockTransaction = $this->stockTransactionRepository->getStockTransaction();
        if($filter){
            $stockTransaction = $this->stockTransactionRepository->getStockTransaction(
            $filter['search'] ?? null,
            $filter['status'] ?? null,
            $filter['type'] ?? null,
            $filter['start'] ?? null,
            $filter['end'] ?? null,
            );
        }
        // dd($stockTransaction->toArray());
        return Excel::download(new StockTransaction($stockTransaction), "ExportProductStock-{$date}.xlsx");
    }

}
