<?php

namespace App\Repositories\StockTransaction;

use LaravelEasyRepository\Repository;

interface StockTransactionRepository extends Repository{

    public function getStockTransaction($search = null, $status = null, $type = null ,$start = null,$end = null);

    public function getFirstDate();
}
