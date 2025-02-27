<?php

namespace App\Services\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Repositories\Product\ProductRepository;
use Exception;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
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

    public function serviceSaveImage($image, $name)
    {
        $manager = new ImageManager(new Driver); // atau 'imagick' jika Anda menggunakan Imagick

        $filename = $name.time().'.'.$image->getClientOriginalExtension();

        // Path untuk gambar asli dan thumbnail
        $originalPath = env('IMAGE_ORI_PUBLIC_PATH');
        $thumbnailPath = env('IMAGE_THUMB_PUBLIC_PATH');

        // Memastikan direktori ada atau buat baru
        if (! file_exists($originalPath)) {
            mkdir($originalPath, 0755, true);
        }
        if (! file_exists($thumbnailPath)) {
            mkdir($thumbnailPath, 0755, true);
        }
        // dd($thumbnailPath . $filename);
        // Simpan Gambar
        try {
            $manager->read($image)
                ->scale(720, 720) // Atur ukuran gambar asli
                ->save($originalPath.$filename);

            $manager->read($image)
                ->resize(100, 100) // Atur ukuran thumbnail
                ->save($thumbnailPath.$filename);
        } catch (Exception $e) {
            dd($e->getMessage());
        }

        return $filename;

    }

    public function serviceDeleteImage($filename)
    {
        if(!$filename){
            return true;
        }
        $ori_path = env('IMAGE_ORI_PUBLIC_PATH').$filename;
        $thumb_path = env('IMAGE_THUMB_PUBLIC_PATH').$filename;
        if (file_exists($ori_path) && file_exists($thumb_path)) {
            unlink($ori_path);
            unlink($thumb_path);
        } else {
            return true;
        }
    }

    public function getAllProduct()
    {
        return $this->mainRepository->getProduct();
    }

    public function searchProducts($search)
    {
        // Pencarian produk berdasarkan nama
    }

    public function getProductPaginate($perPage, $filter = null, $search = null )
    {
        return $this->mainRepository->getProductPaginate($perPage, $filter, $search);
    }

    public function getProductById($id)
    {
        return $this->mainRepository->findProduct($id);
    }

    private function makeSku($idCategory){
        $category = Category::find($idCategory)->name;
        $pref = strtoupper(substr($category, 0, 4));
        $lastSku = Product::where('sku', 'like', $pref . '%')
                      ->orderByDesc('sku')
                      ->first();
        $increment = $lastSku ? (int)substr($lastSku->sku, -4) + 1 : 1;
        $code = str_pad($increment, 4, '0', STR_PAD_LEFT);
        return $pref . $code;
    }

    public function createProduct($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255|unique:products,name',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|unique:products,sku',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0|gt:purchase_price',
            'description' => 'required|string|min:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.string' => 'Nama produk harus berupa teks.',
            'name.max' => 'Nama produk maksimal 255 karakter.',
            'name.unique' => 'Nama produk sudah terdaftar, silakan pilih nama lain.',

            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',

            'purchase_price.required' => 'Harga beli produk wajib diisi.',
            'purchase_price.numeric' => 'Harga beli produk harus berupa angka.',
            'purchase_price.min' => 'Harga beli produk tidak boleh kurang dari 0.',

            'selling_price.required' => 'Harga jual produk wajib diisi.',
            'selling_price.numeric' => 'Harga jual produk harus berupa angka.',
            'selling_price.min' => 'Harga jual produk tidak boleh kurang dari 0.',
            'selling_price.gt' => 'Harga jual produk harus lebih besar dari harga beli.',

            'description.required' => 'Deskripsi produk wajib diisi.',
            'description.string' => 'Deskripsi produk harus berupa teks.',
            'description.min' => 'Deskripsi produk minimal 10 karakter.',

            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Gambar harus bertipe JPEG, PNG, JPG, atau GIF.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);


        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => $validator->errors(),
            ];
        }
        if($data['image']){
            $data['image'] = $this->serviceSaveImage($data['image'], 'product');
        }
        
        $data['sku'] = $this->makeSku($data['category_id']);
        
        $data['atributes'] = array_filter($data['atributes'], function($item) {
            return $item['atribute'] !== null && $item['value'] !== null;
        });

        $data['atributes'] = !empty($data['atributes']) ? $data['atributes'] : null;

        $product = $this->mainRepository->createProduct($data);

        if($data['atributes']){
            foreach ($data['atributes'] as $attribute) {
                ProductAttribute::create([
                    'product_id' => $product->id, // Mengaitkan dengan produk yang baru disimpan
                    'name' => $attribute['atribute'],
                    'value' => $attribute['value'],
                ]);
            }
    
        }

        return [
            'success' => true,
        ];
    }

    public function deleteProduct($id)
    {
        try {
            $productName = $this->mainRepository->findProduct($id)->name;

            $this->serviceDeleteImage($this->mainRepository->findProduct($id)->image);

            $this->mainRepository->deleteProduct($id);

            return [
                'success' => true,
                'message' => "Produk {$productName} berhasil dihapus.",
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function serviceUpdateProduct($data, $id)
    {
        $id = (int) $id;
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
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
                'message' => $validator->errors(),
            ];
        }

        try {

            if ($data['image']) {

                $this->serviceDeleteImage($this->mainRepository->findProduct($id)->image);
                $data['image'] = $this->serviceSaveImage($data['image'], 'product');
            } else {
                unset($data['image']);
            }

            $data['sku'] = $this->makeSku($data['category_id']);

            $this->mainRepository->updateProduct($data, $id);

            $data['atributes'] = array_filter($data['atributes'], function($item) {
                return $item['name'] !== null && $item['value'] !== null;
            });
    
            $data['atributes'] = !empty($data['atributes']) ? $data['atributes'] : null;

            if($data['atributes']){
                foreach ($data['atributes'] as $attribute) {
                    $existingAttribute = ProductAttribute::where('product_id', $id)
                                            ->where('name', $attribute['name'])
                                            ->first();
                    if ($existingAttribute){
                        $existingAttribute->update([
                            'value' => $attribute['value']
                        ]);
                    }else{
                        ProductAttribute::create([
                            'product_id' => $id, // Mengaitkan dengan produk yang baru disimpan
                            'name' => $attribute['name'],
                            'value' => $attribute['value'],
                        ]);
                    }
                }
            }
            

            return [
                'success' => true,
                'message' => "Berhasil Update data {$id}",
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage() . $e->getFile() . $e->getLine(),
            ];
        }
    }
}
