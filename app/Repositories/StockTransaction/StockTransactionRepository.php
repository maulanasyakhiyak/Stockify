<?php

namespace App\Repositories\StockTransaction;

use LaravelEasyRepository\Repository;

interface StockTransactionRepository extends Repository{

    public function searchTransaction($search);

    public function getStockTransaction($searchFilter = null, $status = null, $type = null ,$start = null,$end = null);

    public function getFirstDate();

    public function get_stock_for_chart($range);

    public function store($data);
}
