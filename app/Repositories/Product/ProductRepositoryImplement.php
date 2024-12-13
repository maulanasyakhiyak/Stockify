<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Categories\CategoriesRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaravelEasyRepository\Implementations\Eloquent;

class ProductRepositoryImplement extends Eloquent implements ProductRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     *
     * @property Model|mixed $model;
     */
    protected $model;

    protected $categoriesRepository;

    public function __construct(Product $model, CategoriesRepository $categoriesRepository)
    {
        $this->model = $model;
        $this->categoriesRepository = $categoriesRepository;
    }

    public function getProduct()
    {
        return $this->model->all();
    }

    public function getProductPaginate($num, $filter = null, $search = null)
    {
        $query = $this->model->with('attributes');

        if($search){

            $query->where('name', 'like', '%'.$search.'%');
        }

        if ($filter) {
            if (isset($filter['category'])) {
                $query->where('category_id', $filter['category']);
            }

            if (isset($filter['selling_price_min'])) {
                $query->where('selling_price', '>=', $filter['selling_price_min']);
            }

            if (isset($filter['selling_price_max'])) {
                $query->where('selling_price', '<=', $filter['selling_price_max']);
            }
        }

        return $query->paginate($num);
    }

    public function searchProduct($search, $perPage = null)
    {
        if($perPage){
            return $this->model->where('name', 'like', '%'.$search.'%')->paginate($perPage);
        }else{
            return $this->model->where('name', 'like', '%'.$search.'%')->get();
        }
    }

    public function findProduct($data)
    {
        return $this->model->where('id', $data)->first();
    }

    public function findMultipleProduct($data)
    {
        return $this->model->whereIn('id', $data)->get();
    }

    public function createProduct($data)
    {
        return $this->model->create($data);
    }

    public function deleteProduct($id)
    {
        $product = $this->findProduct($id);
        if (! $product) {
            throw new ModelNotFoundException("Produk dengan ID {$id} tidak ditemukan.");
        }

        return $product->delete();
    }

    public function destroyProduct($data)
    {
        $this->model->destroy($data);

    }

    public function updateProduct($data, $id)
    {
        // dd($data);
        $product = $this->findProduct($id);
        if (! $product) {
            throw new ModelNotFoundException("Produk dengan ID {$id} tidak ditemukan.");
        }

        return $product->update($data);
    }
    public function checkItem($id)
    {
        $item = $this->model::find($id);
        return $item !== null;
    }

    public function sumProduct()
    {
        return $this->model::count();
    }
}
