<?php

namespace App\Repositories\DetailOpname;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\DetailOpname;
use App\Models\RiwayatOpname;

class DetailOpnameRepositoryImplement extends Eloquent implements DetailOpnameRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(DetailOpname $model)
    {
        $this->model = $model;
    }

    public function createDetailOpname($data){
        return $this->model->create($data);
    }

    public function getDataByToken($token, $paginate=null){
        $query = RiwayatOpname::with('detailOpnames.product')->where('token', $token);
        if($paginate){
            return $query->paginate($paginate);
        }else{
            return $query->first();
        }

        if(!$query){
            return null;
        }
    }
}
