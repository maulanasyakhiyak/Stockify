<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BarangKeluar implements FromCollection, WithHeadings
{
    /**
    * @param App\Repositories\StockTransaction\StockTransactionRepository $repository
    * @return \Illuminate\Support\Collection
    */
    protected $repository;

    public function __construct($repository){
        $this->repository = $repository;
    }
    public function collection(){
        $coll = $this->repository->laporan_barang_masuk_keluar('out');
        return $coll->map(function($item){
            return [
                'product_name' => $item->product->name,
                'user_name' => $item->user->first_name.' '.$item->user->last_name,
                'quantity' => $item->quantity,
                'type' => $item->type,
                'date' => Carbon::parse($item->date)->format('j F Y'),
            ];
        });
    }
    public function headings(): array
    {
        return [
            'Product Name',
            'User',
            'Quantity',
            'Type',
            'Date',
        ];
    }
}
