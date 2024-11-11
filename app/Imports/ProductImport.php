<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Pastikan `nama` ada, jika tidak, kembalikan null
        if (empty($row['nama'])) {
            return null;
        }
    
        // Cari kategori berdasarkan nama kategori, gunakan nilai default kosong jika key `category` tidak ada
        $category = Category::where('name', $row['category'] ?? '')->first();
    
        // Ambil nama produk dari `nama`, beri nilai default jika kosong
        $productName = $row['nama'];
    
        // Tangani jika SKU kosong, beri nilai default
        $sku = !empty($row['sku']) ? $row['sku'] : 'default-' . uniqid();
    
        // Tangani jika harga kosong, set 0 jika kosong
        $purchasePrice = !empty($row['purchaseprice']) ? $row['purchaseprice'] : 0;
    
        // Tangani jika selling price kosong, set 0 jika kosong
        $sellingPrice = !empty($row['sellingprice']) ? $row['sellingprice'] : 0;
    
        // Deskripsi default jika kosong
        $description = !empty($row['description']) ? $row['description'] : 'No description';
    
        // Jika kategori ditemukan, gunakan ID kategori, jika tidak, set ke null
        $categoryId = $category ? $category->id : null;
    
        // Cari produk yang memiliki nama yang sama tapi SKU berbeda
        $existingProduct = Product::where('name', $productName)
                                    ->where('sku', '!=', $sku)
                                    ->first();
    
        // Jika ditemukan produk dengan nama yang sama tetapi SKU berbeda
        $counter = 2; // Mulai dengan angka 2
        while ($existingProduct) {
            // Modifikasi nama produk dengan menambahkan (2), (3), (4), ...
            $productName = $row['nama'] . ' (' . $counter . ')';
            $existingProduct = Product::where('name', $productName)
                                      ->where('sku', '!=', $sku)
                                      ->first();
            $counter++;
        }
    
        // Perbarui atau buat produk baru berdasarkan SKU
        return Product::updateOrCreate(
            ['sku' => $sku], // Cek berdasarkan SKU
            [
                'name' => $productName, // Nama produk yang sudah diperbarui
                'sku' => $sku, // SKU, pastikan tidak kosong
                'purchase_price' => $purchasePrice, // Harga beli
                'selling_price' => $sellingPrice, // Harga jual
                'description' => $description, // Deskripsi produk
                'category_id' => $categoryId, // ID kategori
            ]
        );
    }
    

}
