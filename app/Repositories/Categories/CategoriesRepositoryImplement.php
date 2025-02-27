<?php

namespace App\Repositories\Categories;

use Exception;
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

    public function getCategories($paginate = null,$search = null)
    {
        $query = $this->model->query();
        if($search){
            $query->where('name', 'like', '%'.$search.'%');
        }
        if($paginate){
            return $query->paginate($paginate);
        } 
        return $query->get();
    }
    

    public function createCategories($data)
    {
        try {
            $validData = array_filter($data, function ($category) {
                return !empty($category['name']); // Hanya kategori yang 'name'-nya tidak kosong yang akan diproses
            });

            $inserted = $this->model->insert($validData);
            if (!$inserted) {
                throw new Exception('Failed to insert categories');
            }
            return $inserted;
        } catch (Exception $e) {
            throw new Exception('Error while inserting categories: ' . $e->getMessage());
        }
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
