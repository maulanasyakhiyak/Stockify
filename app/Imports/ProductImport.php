<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow, WithEvents
{
    use Importable;
    protected $requiredHeaders = ['name', 'sku', 'purchase price', 'selling price', 'description', 'category'];
    public $added = 0;  // Untuk menghitung jumlah data yang ditambahkan
    public $updated = 0; // Untuk menghitung jumlah data yang diperbarui

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

        // Cari kategori berdasarkan nama kategori, gunakan nilai default kosong jika key `category` tidak ada
        $category = Category::where('name', $row['category'] ?? '')->first();

        // Ambil nama produk dari `nama`, beri nilai default jika kosong
        $productName = $row['name'];

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
        $existingProduct = Product::where('name', $productName)->where('sku', $sku)->first();

        // Jika produk sudah ada, periksa perubahan
        if ($existingProduct) {
            // Periksa jika ada perubahan pada atribut produk (nama, harga, deskripsi, kategori)
            if ($existingProduct->name != $productName ||
            $existingProduct->purchase_price != $purchasePrice ||
            $existingProduct->selling_price != $sellingPrice ||
            $existingProduct->description != $description ||
            $existingProduct->category_id != $categoryId) {

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
            Product::create([
                'name' => $productName,
                'sku' => $sku,
                'purchase_price' => $purchasePrice,
                'selling_price' => $sellingPrice,
                'description' => $description,
                'category_id' => $categoryId,
            ]);
            $this->added++;  // Hitung sebagai data yang ditambahkan
        }

        return null; // Tidak perlu mengembalikan produk karena updateOrCreate sudah menangani itu
    }
}
