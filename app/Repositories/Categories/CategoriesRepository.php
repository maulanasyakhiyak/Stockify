<?php

namespace App\Repositories\Categories;

use LaravelEasyRepository\Repository;

interface CategoriesRepository extends Repository
{
    public function getCategories();
}
