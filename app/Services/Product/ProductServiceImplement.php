<?php

namespace App\Services\Product;

use Exception;
use App\Models\Product;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\Storage;

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

    public function serviceSaveImage($image, $name)
    {
         // Membuat instance ImageManager
    $manager = new ImageManager(new Driver()); // atau 'imagick' jika Anda menggunakan Imagick

    $filename = $name . time() . '.' . $image->getClientOriginalExtension();

    // Path untuk gambar asli dan thumbnail
    $originalPath = env('IMAGE_ORI_PUBLIC_PATH');
    $thumbnailPath =env('IMAGE_THUMB_PUBLIC_PATH');

    // Memastikan direktori ada atau buat baru
    if (!file_exists($originalPath)) {
        mkdir($originalPath, 0755, true);
    }
    if (!file_exists($thumbnailPath)) {
        mkdir($thumbnailPath, 0755, true);
    }
    // dd($thumbnailPath . $filename);
    // Simpan Gambar
    try{
        $manager->read($image)
        ->scale(720, 720) // Atur ukuran gambar asli
        ->save($originalPath.$filename);

        $manager->read($image)
                ->resize(100, 100) // Atur ukuran thumbnail
                ->save($thumbnailPath.$filename);
    }catch(Exception $e){
        dd($e->getMessage());
    }


    return $filename;

    }

    public function getAllProduct()
    {
        return $this->mainRepository->getProduct();
    }

    public function searchProducts($search)
    {
        // Pencarian produk berdasarkan nama
    }

    public function getProductPaginate($perPage, $filter = null)
    {
        return $this->mainRepository->getProductPaginate($perPage, $filter);
    }

    public function getProductById($id)
    {
        return $this->mainRepository->findProduct($id);
    }

    public function createProduct($data)
    {
        $productName = $data['name'];
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255|unique:products,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'description' => 'required|min:10',
        ], [
            'name.unique' => "produk {$productName} sudah ada.",
            'name.required' => 'Nama produk wajib diisi.',
            'name.string' => 'Nama produk harus berupa teks.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori wajib dipilih.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.numeric' => 'Stok harus berupa angka.',
            'stock.min' => 'Stok tidak boleh kurang dari 0.',
            'purchase_price.required' => 'Harga beli wajib diisi.',
            'purchase_price.numeric' => 'Harga beli harus berupa angka.',
            'purchase_price.min' => 'Harga beli tidak boleh kurang dari 0.',
            'selling_price.required' => 'Harga jual wajib diisi.',
            'selling_price.numeric' => 'Harga jual harus berupa angka.',
            'selling_price.min' => 'Harga jual tidak boleh kurang dari 0.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.min' => 'Deskripsi harus terdiri dari minimal 10 karakter.',
        ]);


        if ($validator->fails()) {
            return [
                'success' => false,
                'error' => $validator->errors(),
            ];
        }

        $data['image'] = $this->serviceSaveImage($data['image'], 'product');
        $this->mainRepository->createProduct($data);

        return [
            'success' => true,
        ];
    }

    public function deleteProduct($id)
    {
        try {
            $productName = $this->mainRepository->findProduct($id)->name;
            $filename = $this->mainRepository->findProduct($id)->image;
            unlink(env('IMAGE_ORI_PUBLIC_PATH').$filename);
            unlink(env('IMAGE_THUMB_PUBLIC_PATH').$filename);
            $this->mainRepository->deleteProduct($id);
            return [
                'success' => true,
                'message' => "Produk {$productName} berhasil dihapus."
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function serviceUpdateProduct($data, $id)
    {

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'sku' => 'required|string|max:100|unique:products,sku,' . ($data['id'] ?? 'NULL'),
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0|gt:purchase_price',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama produk harus diisi.',
            'name.string' => 'Nama produk harus berupa teks.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',

            'category_id.required' => 'ID kategori harus diisi.',
            'category_id.integer' => 'ID kategori harus berupa angka.',
            'category_id.exists' => 'ID kategori tidak valid.',

            'sku.required' => 'SKU harus diisi.',
            'sku.string' => 'SKU harus berupa teks.',
            'sku.max' => 'SKU tidak boleh lebih dari 100 karakter.',
            'sku.unique' => 'SKU sudah digunakan oleh produk lain.',

            'purchase_price.required' => 'Harga beli harus diisi.',
            'purchase_price.numeric' => 'Harga beli harus berupa angka.',
            'purchase_price.min' => 'Harga beli tidak boleh kurang dari 0.',

            'selling_price.required' => 'Harga jual harus diisi.',
            'selling_price.numeric' => 'Harga jual harus berupa angka.',
            'selling_price.min' => 'Harga jual tidak boleh kurang dari 0.',
            'selling_price.gt' => 'Harga jual harus lebih besar dari harga beli.',

            'description.string' => 'Deskripsi harus berupa teks.',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'error' => $validator->errors(),
            ];
        }

        try {
            $this->mainRepository->updateProduct($validator->validated(), $id);
            return [
                'success' => true,
                'message' => "Berhasil Update data {$id}"
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
