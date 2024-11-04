<?php

namespace App\Repositories\ProductAttribute;

use LaravelEasyRepository\Repository;

interface ProductAttributeRepository extends Repository
{
    public function getProductAttribute();

    public function getProductAttributePaginate($num);
}
