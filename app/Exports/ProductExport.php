<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    /**
    * Mengambil koleksi data produk yang akan diekspor.
    *
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with('category:id,name')
            ->get()
            ->map(function ($product) {
                return [
                    'nama' => $product->name,
                    'sku' => $product->sku,
                    'purchase_price' => $product->purchase_price,
                    'selling_price' => $product->selling_price,
                    'description' => $product->description,
                    'category' => $product->category ? $product->category->name : 'No Category',
                ];
            });
    }

    /**
    * Menambahkan header pada file yang diekspor.
    *
    * @return array
    */
    public function headings(): array
    {
        return [
            'Name',
            'SKU',
            'Purchase price',
            'Selling price',
            'Description',
            'Category'
        ];
    }
}
