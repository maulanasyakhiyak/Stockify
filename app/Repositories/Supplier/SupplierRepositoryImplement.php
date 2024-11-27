<?php

namespace App\Repositories\Supplier;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Supplier;

class SupplierRepositoryImplement extends Eloquent implements SupplierRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }

    public function index($page = null, $search = null){
        $query = $this->model->query();

        if($search){
            $query->where('name', 'like', "%{$search}%");
        }

        if($page){
            return $query->paginate($page);
        }

        return $query->get();
    }
}
