<?php

namespace App\Repositories\ProductStock;

use App\Models\ProductStock;
use App\Models\ProductStockView;
use LaravelEasyRepository\Implementations\Eloquent;

class ProductStockRepositoryImplement extends Eloquent implements ProductStockRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(ProductStock $model)
    {
        $this->model = $model;
    }

    public function getAll($search = null, $paginate = null){
        $query = $this->model->with('product');
        if($search){
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
        if($paginate){
            return $query->paginate($paginate);
        }else{
            return $query->get();
        }
    }

    public function getOne($id ,$val = null)
    {
        $query = $this->model->with('product');

        if($val){
            return $query->where('product_id', $id)->pluck($val)->first();
        }else{
            $query->find($id);
        }

    }
}
