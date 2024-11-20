<?php

namespace App\Repositories\ProductStock;

use LaravelEasyRepository\Repository;

interface ProductStockRepository extends Repository{

    public function getAll($search = null, $paginate = null);
}
