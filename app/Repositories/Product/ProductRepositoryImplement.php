<?php

namespace App\Repositories\Product;

use App\Models\Product;
use LaravelEasyRepository\Implementations\Eloquent;

class ProductRepositoryImplement extends Eloquent implements ProductRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     *
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getProduct()
    {
        return $this->model->all();
    }
    public function getProductPaginate($num)
    {
        return $this->model->paginate($num);
    }
    
    public function findProduct($data)
    {
        return $this->model->find($data);
    }

    public function createProduct($data)
    {
        return $this->model->create($data);
    }
}
