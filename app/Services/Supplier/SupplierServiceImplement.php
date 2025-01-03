<?php

namespace App\Services\Supplier;

use LaravelEasyRepository\Service;
use App\Repositories\Supplier\SupplierRepository;

class SupplierServiceImplement extends Service implements SupplierService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(SupplierRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
}
