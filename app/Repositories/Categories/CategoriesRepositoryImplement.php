<?php

namespace App\Repositories\Categories;

use App\Models\Category;
use LaravelEasyRepository\Implementations\Eloquent;

class CategoriesRepositoryImplement extends Eloquent implements CategoriesRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     *
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getCategories()
    {
        return $this->model->all();
    }

    public function createCategories($data)
    {
        return $this->model->create($data);
    }

    public function updateCategories($id, $data)
    {
        $currentData = $this->model->find($id);

        if (! $currentData) {
            throw new \Exception('Kategori tidak ditemukan.');
        }

        return $currentData->update($data);
    }

    public function deleteCategories($id)
    {
        $currentData = $this->model->find($id);
        if (! $currentData) {
            throw new \Exception('Kategori tidak ditemukan.');
        }

        return $currentData->delete();

    }
}
