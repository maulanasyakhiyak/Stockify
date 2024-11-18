<?php

namespace App\Repositories\StockTransaction;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\StockTransaction;
use App\Models\User;

class StockTransactionRepositoryImplement extends Eloquent implements StockTransactionRepository{

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

    public function getStockTransaction($search = null, $status = null, $type = null ,$start = null,$end = null){
        $query = $this->model->with('product','user');
        if ($search) {
            $user_id = User::where('name', 'like', '%' . $search . '%')->pluck('id')??null;
            $query->where('user_id', $user_id);
        }

        // Filter berdasarkan status
        if ($status) {
            $query->whereIn('status', $status);
        }

        // Filter berdasarkan tipe transaksi
        if ($type) {
            $query->where('type', $type);
        }

        // Filter berdasarkan rentang tanggal
        if ($start && $end) {
            $query->whereBetween('date', [$start, $end]);
        } elseif ($start) {
            $query->whereDate('date', '>=', $start);
        }

        return $query->get();
    }

    public function getFirstDate(){
        return $this->model->orderBy('date', 'asc')->first()->date;
        if ($firstDate) {
            return $firstDate; // Jika ada data, kembalikan data tersebut
        } else {
            return null; // Jika tidak ada data, kembalikan null atau pesan tertentu
        }
    }
}
