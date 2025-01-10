<?php

namespace App\Repositories\ProductStock;

use LaravelEasyRepository\Repository;

interface ProductStockRepository extends Repository{

    public function getAll($search = null, $paginate = null);
    public function getOne($id ,$val = null);
    public function updateMinimum($id,$minimum_stock);
    public function get_low_stock();
}
