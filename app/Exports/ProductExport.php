<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\ProductAttribute;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    protected $selectedProductIds;
    /**
    * Mengambil koleksi data produk yang akan diekspor.
    *
    * @return \Illuminate\Support\Collection
    */
    public function __construct(array $selectedProductIds = null)
    {
        $this->selectedProductIds = $selectedProductIds;
    }

    public function collection()
    {
        $query = Product::with('category:id,name');
        if (!empty($this->selectedProductIds)) {
            $query->whereIn('id', $this->selectedProductIds);
        }

        $products = $query->get();


        return $products->map(function ($product) {
            $atributeProduct = ProductAttribute::where('product_id' , $product->id)->get()->map(function($atribute){
                return  "{$atribute->name} = {$atribute->value}";
            })->implode(', ');
            return [
                'nama' => $product->name,
                'atribute' => $atributeProduct,
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
            'atribute',
            'SKU',
            'Purchase price',
            'Selling price',
            'Description',
            'Category'
        ];
    }
}
