<?php

namespace App\Services\StockTransaction;

use LaravelEasyRepository\BaseService;

interface StockTransactionService extends BaseService{

    public function stockOpname($data,$keterangan);

    public function store($data);
}
