<?php

namespace App\Services\ProductAttribute;

use App\Repositories\ProductAttribute\ProductAttributeRepository;
use LaravelEasyRepository\Service;

class ProductAttributeServiceImplement extends Service implements ProductAttributeService
{
    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(ProductAttributeRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
}
