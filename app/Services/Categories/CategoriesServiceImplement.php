<?php

namespace App\Services\Categories;

use App\Models\Category;
use App\Repositories\Categories\CategoriesRepository;
use Illuminate\Support\Facades\Validator;
use LaravelEasyRepository\Service;

class CategoriesServiceImplement extends Service implements CategoriesService
{
    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(CategoriesRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function createCategories($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string' => 'Nama kategori harus berupa teks.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 500 karakter.',
        ]);
        if ($validator->fails()) {
            return [
                'success' => false,
                'error' => $validator->errors(),
            ];
        }

        $this->mainRepository->createCategories([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        return [
            'success' => true,
        ];
    }

    public function updateCategories($id, $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string' => 'Nama kategori harus berupa teks.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 500 karakter.',
            'description.required' => 'Deskripsi tidak boleh kosong.',
        ]);
        if ($validator->fails()) {
            return [
                'success' => false,
                'error' => $validator->errors(),
            ];
        }

        $this->mainRepository->updateCategories($id, $data);

        return [
            'success' => true,
        ];
    }

    public function searchCategories($var, $input)
    {
        switch ($var) {
            case 'name':
                return Category::where('name', 'like', '%'.$input.'%')->get();
            case 'id':
                return Category::where('id', 'like', '%'.$input.'%')->get();
            default:
                throw new \Exception('Parameter tidak ditemukan.');
        }
    }
    // Define your custom methods :)
}
