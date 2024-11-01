<?php

namespace App\Repositories\Categories;

use LaravelEasyRepository\Repository;

interface CategoriesRepository extends Repository
{
    public function getCategories();

    public function createCategories($data);

    public function deleteCategories($id);

    public function updateCategories($id, $data);
}
