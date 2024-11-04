<?php

namespace App\Repositories\Product;

use LaravelEasyRepository\Repository;

interface ProductRepository extends Repository
{
    public function getProduct();

    public function deleteProduct($id);

    public function updateProduct($data, $id);

    public function getProductPaginate($num, $filter = null);

    public function searchProduct($perPage, $search);

    public function findProduct($id);

    public function createProduct($data);
}
