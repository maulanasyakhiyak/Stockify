<?php

namespace App\Repositories\Product;

use LaravelEasyRepository\Repository;

interface ProductRepository extends Repository
{
    public function getProduct();

    public function deleteProduct($id);

    public function destroyProduct($data);

    public function updateProduct($data, $id);

    public function getProductPaginate($num, $filter = null, $search = null);

    public function searchProduct($search, $perPage = null);

    public function findProduct($data);

    public function findMultipleProduct($data);

    public function createProduct($data);
}
