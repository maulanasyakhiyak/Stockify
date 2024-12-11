<?php

namespace App\Repositories\StockTransaction;

use LaravelEasyRepository\Repository;

interface StockTransactionRepository extends Repository{

    public function searchTransaction($search);

    public function getStockTransaction($searchFilter = null, $status = null, $type = null ,$start = null,$end = null);

    public function getFirstDate();
}
