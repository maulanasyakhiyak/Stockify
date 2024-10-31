<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\Validator;
use LaravelEasyRepository\Service;

class ProductServiceImplement extends Service implements ProductService
{
    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(ProductRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function getAllProduct()
    {
        return $this->mainRepository->getProduct();
    }

    public function searchProducts($search)
    {
        return Product::with(['category', 'attributes'])->where('name', 'like', '%'.$search.'%')->get(); // Pencarian produk berdasarkan nama
    }

    public function getProductPaginate($num)
    {
        return $this->mainRepository->getProduct($num);
    }

    public function getProductById($id)
    {
        return $this->mainRepository->findProduct($id);
    }

    public function createProduct($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'category' => 'required',
            'stock' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'description' => 'required|min:10',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.string' => 'Nama produk harus berupa teks.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
            'category.required' => 'Kategori wajib dipilih.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.numeric' => 'Stok harus berupa angka.',
            'stock.min' => 'Stok tidak boleh kurang dari 0.',
            'purchase_price.required' => 'Harga beli wajib diisi.',
            'purchase_price.numeric' => 'Harga beli harus berupa angka.',
            'purchase_price.min' => 'Harga beli tidak boleh kurang dari 0.',
            'sale_price.required' => 'Harga jual wajib diisi.',
            'sale_price.numeric' => 'Harga jual harus berupa angka.',
            'sale_price.min' => 'Harga jual tidak boleh kurang dari 0.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.min' => 'Deskripsi harus terdiri dari minimal 10 karakter.',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'error' => $validator->errors(),
            ];
        }

        $this->mainRepository->createProduct($validator->validated());

        return [
            'success' => true,
        ];
    }
}
