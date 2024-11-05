<?php

namespace App\Services\Product;

use LaravelEasyRepository\BaseService;

interface ProductService extends BaseService
{
    public function getAllProduct();

    public function searchProducts($search);

    public function getProductPaginate($perPage, $filter = null);

    public function getProductById($id);

    public function createProduct($data);

    public function deleteProduct($id);

    public function serviceUpdateProduct($data, $id);

    public function serviceSaveImage($image, $name);

    public function serviceDeleteImage($image);
}
