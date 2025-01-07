<?php

namespace App\Http\Controllers\admin;

use App\Exports\ProductStock;
use App\Exports\StockTransaction;
use Illuminate\Http\Request;
use App\Exports\UserActivity;
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
        $stockTransaction = $this->stockTransactionRepository->getStockTransaction();
        $productStock = $this->productStockRepository->getAll();
        $filter = session('/'.$request->path());
        if($filter || $request->has('search')){
            $stockTransaction = $this->stockTransactionRepository->getStockTransaction(
            $filter['search'] ?? null,
            $filter['status'] ?? null,
            $filter['type'] ?? null,
            $filter['start'] ?? null,
            $filter['end'] ?? null,
            );
        }
        $earliestDate =  $this->stockTransactionRepository->getFirstDate();
        return view('adminpage.laporan', compact('user_activity','stockTransaction','earliestDate','productStock','filter'));
    }

    public function ExportUserActivity(){
        $date = now()->format('Y-m-d');
        $timeRange = session('activity')['range'];
        return Excel::download(new UserActivity($timeRange), "UserActivity-{$date}.xlsx");
    }
    
    public function ExportProductStock(){
        $date = now()->format('Y-m-d');
        return Excel::download(new ProductStock($this->productStockRepository), "ExportProductStock-{$date}.xlsx");
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
