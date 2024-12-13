<?php

namespace App\Repositories\StockTransaction;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Implementations\Eloquent;

class StockTransactionRepositoryImplement extends Eloquent implements StockTransactionRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(StockTransaction $model)
    {
        $this->model = $model;
    }

    public function searchTransaction($search)
    {
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

    public function getStockTransaction($searchFilter = null, $status = null, $type = null, $start = null, $end = null)
    {
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

        return $query->get();
    }

    public function getFirstDate()
    {
        $this->model->orderBy('date', 'asc')->first()->date ?? 0;
    }

    public function get_stock_for_chart($range)
    {
        if ($range) {
            $now = Carbon::now();
            switch ($range) {
                case '7-days':
                    $data = $this->model->select(DB::raw('DATE(date) as tanggal, SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) as total_quantity'))
                        ->where('status', 'completed')
                        ->where('date', '>=', $now->subWeek())
                        ->groupBy(DB::raw('DATE(date)'))
                        ->get();
                    break;

                case '1-month':
                    $data = $this->model
                        ->where('status', 'completed')
                        ->select(DB::raw('FLOOR((DAY(date) - 1) / 7) + 1 AS minggu, SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) as total'))
                        ->where('date', '>=', Carbon::now()->subMonth())
                        ->groupBy(DB::raw('FLOOR((DAY(date) - 1) / 7) + 1'))
                        ->get();

                    $weeks = collect(range(1, 5));

                    $lastWeek = $data->sortByDesc('minggu')->first();

                    // Mendeklarasikan $sumTotal untuk menyimpan total keseluruhan
                    $sumTotal = 0;

                    $data = $weeks->map(function ($week) use ($data, &$sumTotal, $lastWeek) {
                        // // Mencari data untuk minggu tertentu
                        $dataItem = $data->firstWhere('minggu', $week);

                        $sumTotal += $dataItem ? $dataItem->total : 0;
                        $total = $dataItem ? $dataItem->total : 0;
                        if ($lastWeek->minggu < $week) {
                            $sumTotal = null;
                            $total = null;
                        }

                        return [
                            'date' => $week . ' week',
                            'total' => $total,
                            'total_quantity' => $sumTotal,
                        ];
                    });

                    break;

                case '1-year':
                    $data = $this->model
                        ->where('status', 'completed')
                        ->select(DB::raw('YEAR(date) as tahun, MONTH(date) as bulan, SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) as total'))
                        ->where('date', '>=', Carbon::now()->subYear())
                        ->groupBy(DB::raw('YEAR(date), MONTH(date)'))
                        ->get();
                    $months = collect(range(1, 12));
                    $sumTotal = 0;
                    $lastMonth = $data->sortByDesc('bulan')->first();
                    $data = $months->map(function ($month) use ($data, &$sumTotal, $lastMonth) {
                        $dataItem = $data->firstWhere('bulan', $month);
                        $sumTotal += $dataItem ? $dataItem->total : 0;
                        $total = $dataItem ? $dataItem->total : 0;
                        if ($lastMonth->bulan < $month) {
                            $sumTotal = null;
                            $total = null;
                        }
                        if (!$dataItem) {
                            return [
                                'date' => Carbon::createFromFormat('m', $month)->format('F'),
                                'total' => $total,
                                'total_quantity' => $sumTotal,
                            ];
                        }
                        // Jika ada data, kembalikan data seperti biasa
                        return [
                            'date' => Carbon::createFromFormat('m', $dataItem->bulan)->format('F'),
                            'total' => $total,
                            'total_quantity' => $sumTotal,
                        ];
                    });


                default:
                    $dat = $this->model->select(DB::raw('DATE(date) as tanggal, SUM(CASE WHEN type = "in" THEN quantity ELSE -quantity END) as total_quantity'))
                        ->where('status', 'completed')
                        ->groupBy('date')
                        ->get();
                    break;
            }
        }




        return [
            // 'total' => $totalAccumulated,
            // 'message' => $message,
            'data' => $data
        ];
    }
}
