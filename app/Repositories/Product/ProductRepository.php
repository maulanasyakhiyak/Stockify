<?php

namespace App\Repositories\Product;

use LaravelEasyRepository\Repository;

interface ProductRepository extends Repository
{
    public function getProduct();
    public function getProductPaginate($num);

    public function findProduct($id);

    public function createProduct($data);
}
