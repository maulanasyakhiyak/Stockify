<?php

namespace App\Exports;

use App\Repositories\StockTransaction\StockTransactionRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductStock implements FromCollection,WithHeadings
{
    /**
    * @param array $filter need star_date, end_date, category id this is optional
    * @return \Illuminate\Support\Collection
    */
    protected $filter;
    protected $stockTransactionRepository;
    public function __construct($filter,$stockTransactionRepository) {
        $this->filter = $filter;
        $this->stockTransactionRepository = $stockTransactionRepository;
    }
    public function collection()
    {
        $data = $this->stockTransactionRepository->laporanStokBarang($this->filter['start_date'],$this->filter['end_date'],$this->filter['category']);
        return $data->map(function($item){
            return [
                'SKU' => $item['SKU'],
                'Nama Produk' => $item['product_name'],
                'Kategori' => $item['category_name'],
                'Jumlah' => $item['total_quantity'],
            ];
        });

    }

    public function headings(): array
    {
        return ['SKU', 'Nama Produk', 'Kategori', 'Jumlah'];
    }
}
