<?php

namespace App\Exports;

use App\Repositories\StockTransaction\StockTransactionRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockTransaction implements FromCollection, WithHeadings
{
    /**
        * @param string Require stock transaction filter to export
    */

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        return $this->data->map(function ($item){
            return [
                'Product Name' => $item->product->name,
                'User' => $item->user->first_name. ' ' . $item->user->last_name,
                'Transaction Type' => $item->type,
                'Quantity' => $item->quantity,
                'Status' => $item->status,
                'Date' => $item->date,
                'Notes' => $item->notes,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'User',
            'Transaction Type',
            'Quantity',
            'Status',
            'Date',
            'Notes',
        ];
    }
}
