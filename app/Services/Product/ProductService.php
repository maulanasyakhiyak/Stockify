<?php

namespace App\Services\Product;

use LaravelEasyRepository\BaseService;

interface ProductService extends BaseService
{
    public function getAllProduct();

    public function searchProducts($search);

    public function getProductPaginate($num);

    public function getProductById($id);

    public function createProduct($data);
}
