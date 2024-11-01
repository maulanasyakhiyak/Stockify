<?php

namespace App\Services\Categories;

use LaravelEasyRepository\BaseService;

interface CategoriesService extends BaseService
{
    public function createCategories($data);

    public function updateCategories($id, $data);

    public function searchCategories($var, $input);
}
