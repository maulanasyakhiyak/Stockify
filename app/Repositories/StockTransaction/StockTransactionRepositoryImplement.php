<?php

namespace App\Repositories\StockTransaction;

use App\Models\Product;
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

    public function searchTransaction($search){
        $query = $this->model->with('product','user');
        $product_id = Product::where('name', 'like', '%' . $search . '%')->first()->id ?? null;
        $user_id = User::where('name', 'like', '%' . $search . '%')->first()->id ?? null;
        if($product_id){
            $query->where('product_id', $product_id);
        }
        if($user_id){
            $query->where('user_id', $user_id);
        }
        return $query->get();

    }

    public function getStockTransaction($searchFilter = null, $status = null, $type = null ,$start = null,$end = null, $search = null){
    //    dd($search);
        $query = $this->model->with('product','user');
        $product_query = Product::query();
        $user_query = User::query();

        if ($searchFilter) {
            $product_id = $product_query->where('name', 'like', '%' . $search . '%')->first()->id ?? null;
            $user_id = $user_query->where('name', 'like', '%' . $search . '%')->first()->id ?? null;
            if($product_id){
                $query->where('product_id', $product_id);
            }
            if($user_id){
                $query->where('user_id', $user_id);
            }
        }

        // Pakai SEARCH

        // $product_id = null;
        // $user_id = null;

        // if ($searchFilter && $search) {
        //     $product_id = $product_query->where('name', 'like', '%' . $searchFilter . '%')->first()->id ?? null;
        //     $user_id = $user_query->where('name', 'like', '%' . $search . '%')->first()->id ?? null;
        // } elseif ($searchFilter) {
        //     $product_id = $product_query->where('name', 'like', '%' . $searchFilter . '%')->first()->id ?? null;
        // } elseif ($search) {
        //     $product_id = $product_query->where('name', 'like', '%' . $search . '%')->first()->id ?? null;
        //     $user_id = $user_query->where('name', 'like', '%' . $search . '%')->first()->id ?? null;
        // }

        // if($product_id){
        //     $query->where('product_id', $product_id);
        // }
        // if($user_id){
        //     $query->where('user_id', $user_id);
        // }

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

    public function getFirstDate(){
        $this->model->orderBy('date', 'asc')->first()->date ?? 0;
    }
}
