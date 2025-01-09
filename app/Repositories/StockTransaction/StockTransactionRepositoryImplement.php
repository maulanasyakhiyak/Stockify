<?php

namespace App\Repositories\StockTransaction;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Events\UserActivityLogged;
use App\Models\ProductStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use LaravelEasyRepository\Implementations\Eloquent;

class StockTransactionRepositoryImplement extends Eloquent implements StockTransactionRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;
    protected $productStock;

    public function __construct(StockTransaction $model,ProductStock $productStock)
    {
        $this->model = $model;
        $this->productStock = $productStock;
    }

    public function searchTransaction($search){
        $query = $this->model->with('product', 'user');
        $product_id = Product::where('name', 'like', '%' . $search . '%')->first()->id ?? null;
        $user_id = User::where('name', 'like', '%' . $search . '%')->first()->id ?? null;
        if ($product_id) {
            $query->where('product_id', $product_id);
        }
        if ($user_id) {
            $query->where('user_id', $user_id);
        }
        return $query->get();
    }

    public function getStockTransaction($searchFilter = null, $status = null, $type = null, $start = null, $end = null){
        //    dd($search);
        $query = $this->model->with('product', 'user');
        $product_query = Product::query();
        $user_query = User::query();

        if ($searchFilter) {
            $product_id = $product_query->where('name', 'like', '%' . $searchFilter . '%')->first()->id ?? null;
            $query->where('product_id', $product_id);
        }

        // Filter berdasarkan status
        if ($status) {
            $query->whereIn('status', $status);
        }

        // Filter berdasarkan tipe transaksi
        if ($type) {
            $query->where('type', $type);
        }

        if ($start && $end) {
            $query->whereBetween('date', [$start, $end]);
        } elseif ($start) {
            $query->whereDate('date', '>=', $start);
        }

        return $query->orderBy('date')->get();
    }

    public function getFirstDate(){
        $this->model->orderBy('date', 'asc')->first()->date ?? 0;
    }

    public function get_stock_for_chart($range){
        if ($range) {
            $query = $this->model
                ->selectRaw('date, YEAR(date) as year, MONTH(date) as month, DAY(date) as day, WEEK(date) as week, SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) as total_quantity')
                ->where('status', 'completed');
                
            $endDate = Carbon::now();
            $startDate = null;
        
            switch ($range) {
                case '1-month':
                    $message = 'Stock in last 1 month';
                        $startDate = $endDate->copy()->subMonth();
                    $query = $query->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                        ->groupBy(DB::raw('date,YEAR(date), MONTH(date), WEEK(date)'))
                        ->orderBy('date');
                    $formatDate = function($item) {
                        return Carbon::parse($item->date)->startOfMonth()->format('Y-m-d');
                    };
                    break;
        
                case '1-year':
                    $message = 'Stock in last 1 year';
                        $startDate = $endDate->copy()->subYear();
                    $query = $query->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                        ->groupBy(DB::raw('date,YEAR(date), MONTH(date)'))
                        ->orderBy('date');
                    $formatDate = function($item) {
                        return Carbon::parse($item->year.'-'.$item->month.'-01')->format('F Y');
                    };
                    break;
        
                case '7-days':
                    $message = 'Stock in this week';
                        $startDate = $endDate->copy()->subDays(7);
                    $query = $query->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                        ->groupBy(DB::raw('date,YEAR(date), MONTH(date), DAY(date)'))
                        ->orderBy('date');
                    $formatDate = function($item) {
                        return Carbon::parse($item->day)->format('l');
                    };
                    break;
        
                default:
                    $message = 'Stock all time';
                    $startDate = $this->model->min('date');
                    $query = $query->whereBetween('date', [$startDate, $endDate->format('Y-m-d')])
                        ->groupBy(DB::raw('date,YEAR(date), MONTH(date)'))
                        ->orderBy('date');
                    $formatDate = function($item) {
                        return Carbon::parse($item->year.'-'.$item->month.'-01')->format('F Y');
                    };
            }
        
            $total_before = $this->model
                ->selectRaw('SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) as total')
                ->where('date', '<', $startDate)
                ->where('status', 'completed')
                ->first();
        
            $total_stock = $total_before->total ?? 0;
            $data = $query->get()->map(function($item) use (&$total, &$total_stock, $formatDate) {
                $total += $item->total_quantity ?? 0;
                $total_stock += $item->total_quantity ?? 0;
                return [
                    'date' => $formatDate($item),
                    'quantity' => $item->total_quantity,
                    'total_quantity' => $total_stock,
                ];
            });
        }
        

        return [
            'total' => $total_stock,
            'message' => $message,
            'data' => $data,
        ];
    }

    public function store($data){
        $product_id = Product::where('sku' , $data['sku'])->pluck('id');
        if($product_id->isEmpty()){
            return['message' => 'Product not found'];
        }
        event(new UserActivityLogged(auth()->id(), 'add', "adding new transaction with SKU : {$data['sku']}"));
        // adding NEW STOCK
        $stock = $this->productStock->find($product_id[0]);
        if ($stock) {
            $stock->increment('stock', $data['quantity'] * ($data['type'] === 'in' ? 1 : -1));
        } else {
            $this->productStock->create([
                'product_id' => $product_id[0],
                'stock' => $data['quantity'] * ($data['type'] === 'in' ? 1 : -1),
            ]);
        }

        return $this->model->create([
            'product_id' => $product_id[0],
            'user_id' => auth()->id(),
            'type' => $data['type'],
            'quantity' => $data['quantity'],
            'status' => 'pending',
            'date' => Carbon::now()->format('Y-m-d')
        ]);
    }

    public function get_total_transaction($option='in'){
        if($option === 'in'){
            return $this->model
                    ->where('status', 'completed')
                    ->where('type', 'in')
                    ->count(); 
        }
        if($option === 'out'){
                return $this->model
                    ->where('status', 'completed')
                    ->where('type', 'out')
                    ->count();
        }
    }

    public function get_total_stock(){
        $data = $this->model->selectRaw('SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) as total')
                    ->where('status', 'completed')->first();
        return $data->total;
    }

    public function laporanStokBarang($date_start = null, $date_end = null, $kategoriId = null){
        $query = $this->model->with('product')->where('status', 'completed');
        $startDate = $query->min('date');
        if($date_start && $date_end){
            $startDate = Carbon::parse($date_start)->format('Y-m-d');
            $endDate = Carbon::parse($date_end)->format('Y-m-d');
            $query->whereBetween('date', [$startDate, $endDate]);
        }
        // Jika kategori diberikan, filter berdasarkan kategori
        if ($kategoriId) {
            $query->whereHas('product.category', function ($query) use ($kategoriId) {
                $query->where('id', $kategoriId);
            });
        }

        // $stokBarang = $query->selectRaw("product_id, 
        //                          $groupBy as periode, 
        //                          SUM(CASE WHEN type = 'in' THEN quantity ELSE -quantity END) as total_quantity")
        //                     ->groupBy('product_id', DB::raw($groupBy))
        //                     ->orderBy(DB::raw($groupBy), 'asc')
        //                     ->groupBy('product_id')
        //                     ->get();
        $laporan = $query->select('product_id')
                    ->selectRaw("SUM(CASE WHEN type = 'in' THEN quantity ELSE -quantity END) as total_quantity")
                    ->groupBy('product_id')
                    ->get()->map(function($item) use($startDate){
                        $totalBefore = $this->model->where('status', 'completed')
                                    ->where('product_id', $item->product_id)
                                    ->where('date', '<' ,$startDate)
                                    ->selectRaw("SUM(CASE WHEN type = 'in' THEN quantity ELSE -quantity END) as total")
                                    ->first()->total ?? 0;

                        return [
                            'total_bfore' =>$totalBefore ?? 0,
                            'SKU' => $item->product->sku,
                            'product_id' => $item->product_id,
                            'total_quantity' => $item->total_quantity,
                            'product_name' => $item->product->name,
                            'category_name' => $item->product->category->name,
                            ];
                    });

        
        // $total = 0;
        // ->map(function ($item) use(&$total){
        //     $total += $item->total_quantity;
        //     return [
        //         'product_id' => $item->product_id,
        //         'periode' => $item->periode,
        //         'stok' => $item->total_quantity,
        //         'total' => $total,
        //     ];
        // });

        // dd($laporan->toArray());

        return $laporan;
    }
}


    // $now = Carbon::now();
    // switch ($range) {
    //     case '7-days':
    //         $data = $this->model
    //             ->where('status', 'completed')
    //             ->select(DB::raw(' DAYOFWEEK(date) AS hari, SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) as total'))
    //             ->where('date', '>=', $now->subWeek())
    //             ->groupBy(DB::raw(' DAYOFWEEK(date) '))
    //             ->get();

    //             $days = collect(range(1,7));
    //             $lastDay = $data->sortByDesc('hari')->first();

    //             $sumTotal = 0;
    //             $data = $days->map(function ($day) use ($data, &$sumTotal, $lastDay) {
    //                 // // Mencari data untuk minggu tertentu
    //                 $dataItem = $data->firstWhere('hari', $day);
    //                 $sumTotal += $dataItem ? $dataItem->total : 0;
    //                 $total = $dataItem ? $dataItem->total : 0;
    //                 if($lastDay){
    //                     if ( $lastDay->hari < $day) {
    //                         $sumTotal = null;
    //                         $total = null;
    //                     }
    //                 }
    //                 return [
    //                     'date' => Carbon::create()->startOfWeek()->addDays($day - 1)->locale('id')->dayName ,
    //                     'total' => $total,
    //                     'total_quantity' => $sumTotal,
    //                 ];
    //             });
    //         break;

    //     case '1-month':
    //         $data = $this->model
    //             ->where('status', 'completed')
    //             ->select(DB::raw('FLOOR((DAY(date) - 1) / 7) + 1 AS minggu, SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) as total'))
    //             ->where('date', '>=', Carbon::now()->subMonth())
    //             ->groupBy(DB::raw('FLOOR((DAY(date) - 1) / 7) + 1'))
    //             ->get();

    //         $totalBefore = $this->model
    //             ->where('status', 'completed')
    //             ->where('date', '<', Carbon::now()->startOfMonth()) // Ambil data sebelum bulan ini
    //             ->sum(DB::raw('CASE WHEN type = "in" THEN quantity ELSE -quantity END'));

    //         $weeks = collect(range(1, 5));

    //         $lastWeek = $data->sortByDesc('minggu')->first();

    //         // Mendeklarasikan $sumTotal untuk menyimpan total keseluruhan
    //         $sumTotal = 0;

    //         $data = $weeks->map(function ($week) use ($data, &$sumTotal, $lastWeek,$totalBefore) {
    //             $item = $data->firstWhere('minggu',$week);
    //             $sumTotal += $item ? $item->total : 0;
    //             $total = $item ? $item->total : 0;

    //             if($week == 1){
    //                 $sumTotal += $totalBefore;
    //             }

    //             if ( $lastWeek->minggu < $week) {
    //                 $sumTotal = null;
    //                 $total = null;
    //             }

    //             return [
    //                 'date' => $week . ' week',
    //                 'total' => $total,
    //                 'total_quantity' => $sumTotal,
    //             ];
    //         });

    //         break;

    //     case '1-year':
    //         $data = $this->model
    //             ->where('status', 'completed')
    //             ->select(DB::raw('YEAR(date) as tahun, MONTH(date) as bulan, SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) as total'))
    //             ->where('date', '>=', Carbon::now()->subYear())
    //             ->groupBy(DB::raw('YEAR(date), MONTH(date)'))
    //             ->get();
    //         $totalBefore = $this->model
    //             ->where('status', 'completed')
    //             ->where('date', '<', Carbon::now()->startOfYear()) // Ambil data sebelum bulan ini
    //             ->sum(DB::raw('CASE WHEN type = "in" THEN quantity ELSE -quantity END'));
    //         $months = collect(range(1, 12));
    //         $sumTotal = 0;
    //         $lastMonth = $data->sortByDesc('bulan')->first();
    //         $data = $months->map(function ($month) use ($data, &$sumTotal, $lastMonth,$totalBefore) {
    //             $dataItem = $data->firstWhere('bulan', $month);
    //             $sumTotal += $dataItem ? $dataItem->total : 0;
    //             $total = $dataItem ? $dataItem->total : 0;
    //             if($month == 1){
    //                 $sumTotal += $totalBefore;
    //             }
    //             if ($lastMonth->bulan < $month) {
    //                 $sumTotal = null;
    //                 $total = null;
    //             }
    //             if (!$dataItem) {
    //                 return [
    //                     'date' => Carbon::createFromFormat('m', $month)->format('F'),
    //                     'total' => $total,
    //                     'total_quantity' => $sumTotal,
    //                 ];
    //             }
    //             // Jika ada data, kembalikan data seperti biasa
    //             return [
    //                 'date' => Carbon::createFromFormat('m', $dataItem->bulan)->format('F'),
    //                 'total' => $total,
    //                 'total_quantity' => $sumTotal,
    //             ];
    //         });

    //     break;

    //     case 'all-time':
    //         $data = $this->model->select(DB::raw('DATE(date) as date, SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) as total'))
    //             ->where('status', 'completed')
    //             ->groupBy('date')
    //             ->get();

    //         $sumTotal = 0 ;
    //         $data = $data->map(function ($item) use(&$sumTotal) {
    //             $sumTotal += $item ? $item->total : 0;
    //             $total = $item ? $item->total : 0;
    //             return [
    //                 'date' => $item->date,
    //                 'total' => $total,
    //                 'total_quantity' => $sumTotal,
    //             ];
    //         });
    //         break;
         
