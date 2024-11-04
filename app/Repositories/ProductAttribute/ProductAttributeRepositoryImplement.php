<?php

namespace App\Repositories\ProductAttribute;

use App\Models\ProductAttribute;
use LaravelEasyRepository\Implementations\Eloquent;

class ProductAttributeRepositoryImplement extends Eloquent implements ProductAttributeRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     *
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(ProductAttribute $model)
    {
        $this->model = $model;
    }

    public function getProductAttribute()
    {
        return $this->model->all();
    }

    public function getProductAttributePaginate($num)
    {
        return $this->model->paginate($num);
    }
}
