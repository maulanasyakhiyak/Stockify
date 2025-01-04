<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductStock implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $ProductStockRepository;

    public function __construct($ProductStockRepository) {
        $this->ProductStockRepository = $ProductStockRepository;
    }
    public function collection()
    {
        $data = $this->ProductStockRepository->getAll();
        return $data->map(function($item){
            return [
                $item->product_name,
                $item->sku,
                $item->minimal_stock ?? 'kosong',
                $item->stock_akhir,
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama Produk', 'SKU', 'Pengaturan Stock Minimal', 'Total Stock'];
    }
}
