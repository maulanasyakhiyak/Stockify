<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow, WithEvents
{
    use Importable;
    protected $requiredHeaders = ['name', 'sku', 'purchase price', 'selling price', 'description', 'category', 'atributes'];
    public $added = 0;  // Untuk menghitung jumlah data yang ditambahkan
    public $updated = 0; // Untuk menghitung jumlah data yang diperbarui
    public $newCategories = [];
    protected $duplicatedProductName;
    protected $arrayProductName = [];
    protected $counterProductName = 2;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $sheet = $event->reader->getSheet(0);
                $headerRow = array_map('strtolower', $sheet->toArray()[0]);
                $missingHeaders = array_diff($this->requiredHeaders, $headerRow);

                if (!empty($missingHeaders)) {
                    throw new \Exception('Header tidak sesuai: ' . implode(', ', $missingHeaders));
                }
            },
        ];
    }
    public function model(array $row)
    {
        // Pastikan `nama` ada, jika tidak, kembalikan null
        if (empty($row['name'])) {
            return null;
        }

        $categoryName = $row['category'] ?? '';

        // Jika kategori tidak ditemukan, tambahkan ke daftar kategori baru
        $category = Category::where('name', $categoryName)->first();
        if (!$category && $categoryName !== '' && !in_array($categoryName, $this->newCategories)) {
            $this->newCategories[] = $categoryName;
        }

        // Jika ada kategori baru, hentikan proses dan kembalikan daftar kategori baru untuk ditinjau pengguna
        if (!empty($this->newCategories)) {
            return null;  // Hentikan proses jika ada kategori baru
        }


        // Ambil nama produk dari `nama`, beri nilai default jika kosong
        $productName = $row['name'];

        $attributesData = $row['atributes'] ?? '';

        // Tangani jika SKU kosong, beri nilai default
        $sku = !empty($row['sku']) ? $row['sku'] : 'default-' . uniqid();

        // Tangani jika harga kosong, set 0 jika kosong
        $purchasePrice = !empty($row['purchase_price']) ? $row['purchase_price'] : 0;

        // Tangani jika selling price kosong, set 0 jika kosong
        $sellingPrice = !empty($row['selling_price']) ? $row['selling_price'] : 0;

        // Deskripsi default jika kosong
        $description = !empty($row['description']) ? $row['description'] : 'No description';

        // Jika kategori ditemukan, gunakan ID kategori, jika tidak, set ke null
        $categoryId = $category ? $category->id : null;

        // Cari produk berdasarkan SKU
        $existingProduct = Product::where('sku', $sku)->first();

        $newAttributesProduct = [];
        if (!empty($attributesData)) {
            $atributes = explode(',', $attributesData);
            foreach ($atributes as $atribute) {
                [$key, $value] = explode('=', $atribute) + [null, null];
                if ($key && $value) {
                    $newAttributesProduct[] = [
                        'name' => trim($key),
                        'value' => trim($value)
                    ];
                }
            }
        }

        // Jika produk sudah ada, periksa perubahan
        if ($existingProduct) {

            if ($this->duplicatedProductName === $productName || in_array($productName, $this->arrayProductName)) {
                // Reset nama produk duplikat
                $this->duplicatedProductName = $productName;

                // Tambahkan angka hingga nama produk menjadi unik
                while (in_array($productName, $this->arrayProductName)) {
                    $productName = $productName . ' (' . $this->counterProductName . ')';
                    $this->counterProductName++;
                }

                // Tambahkan nama produk yang sudah unik ke array
                $this->arrayProductName[] = $productName;
            } else {
                // Jika nama tidak duplikat, simpan langsung
                $this->duplicatedProductName = $productName;
                $this->arrayProductName[] = $productName;
            }

            $existingAttributeMap =  ProductAttribute::where('product_id', $existingProduct->id)->get()->map(function ($item) {
                return [
                    'name' => $item->name,
                    'value' => $item->value
                ];
            })->toArray();

            $attrNotInImport = array_udiff($existingAttributeMap ,$newAttributesProduct,function($a, $b) {
                if ($a['name'] === $b['name'] && $a['value'] === $b['value']) {
                    return 0;
                }
                return 1;
            });
            foreach($attrNotInImport as $deleted){
                ProductAttribute::where('product_id', $existingProduct->id)->where('name', $deleted['name'])->where('value', $deleted['value'])
                ->delete();
            }

            $newAttrHasDiff = array_udiff($newAttributesProduct,$existingAttributeMap ,function($a, $b) {
                if ($a['name'] === $b['name'] && $a['value'] === $b['value']) {
                    return 0;
                }
                return 1;
            });


            // Periksa jika ada perubahan pada atribut produk (nama, harga, deskripsi, kategori)
            if (
                $existingProduct->name != $productName ||
                $existingProduct->purchase_price != $purchasePrice ||
                $existingProduct->selling_price != $sellingPrice ||
                $existingProduct->description != $description ||
                $existingProduct->category_id != $categoryId ||
                count($newAttrHasDiff) > 0
            ) {

                foreach ($newAttributesProduct as $item) {
                    $existingAttribute = ProductAttribute::where('product_id', $existingProduct->id)->where('name', $item['name'])->first();
                    if ($existingAttribute) {
                        if ($existingAttribute->name !== $item['name']) {
                            $existingAttribute->update([
                                'name' => $item['name']
                            ]);
                        }
                        if ($existingAttribute->value !== $item['value']) {
                            $existingAttribute->update([
                                'value' => $item['value']
                            ]);
                        }
                    } else {
                        ProductAttribute::create([
                            'product_id' => $existingProduct->id,
                            'name' => $item['name'],
                            'value' => $item['value'],
                        ]);
                    }
                }

                $existingProduct->update([
                    'name' => $productName,
                    'purchase_price' => $purchasePrice,
                    'selling_price' => $sellingPrice,
                    'description' => $description,
                    'category_id' => $categoryId,
                ]);

                $this->updated++;  // Hitung sebagai update
            }
        } else {
            $counter = 2;
            while (Product::where('name', $productName)->exists()) {
                $productName = $row['name'] . ' (' . $counter . ')';
                $counter++;
            }

            // Jika produk tidak ada, buat produk baru
            $product = Product::create([
                'name' => $productName,
                'sku' => $sku,
                'purchase_price' => $purchasePrice,
                'selling_price' => $sellingPrice,
                'description' => $description,
                'category_id' => $categoryId,
            ]);
            foreach ($newAttributesProduct as $i) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'name' => $i['name'],
                    'value' => $i['value']
                ]);
            }
            $this->added++;  // Hitung sebagai data yang ditambahkan
        }

        return null; // Tidak perlu mengembalikan produk karena updateOrCreate sudah menangani itu
    }
    // Method untuk mendapatkan daftar kategori baru
    public function getNewCategories()
    {
        return $this->newCategories;
    }
}
