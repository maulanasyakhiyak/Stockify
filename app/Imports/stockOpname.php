<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\BeforeImport;

class stockOpname implements ToModel, WithEvents, WithHeadingRow
{
    protected $products = [];
    protected $requiredHeaders = ['sku', 'value',];
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $sheet = $event->reader->getSheet(0);
                $headerRow = array_map('strtolower', $sheet->toArray()[0]);
                $missingHeaders = array_diff($this->requiredHeaders, $headerRow);

                if (!empty($missingHeaders)) {
                    throw new \Exception('Header tidak ada atau tidak sesuai: ' . implode(', ', $missingHeaders));
                }
            },
        ];
    }
    public function model(array $row)
    {   
        $sku = $row['sku'] ?? '';
        if(is_int($row['value']) && $row['value'] >= 0){
            $value = $row['value'];
        }else {
            $value = 0;
        }

        $product = Product::where('sku', $sku)->first();

        if($product){
            $this->products[]=[
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $sku,
                'value' => $value
            ];
        }else{
            $this->products[]=[
                'error' => 'Not Found',
                'message' => $sku,
            ];
        }
    }
    public function getProducts()
    {
        $allHaveError = true;
        foreach ($this->products as $item) {
            if (!array_key_exists('error', $item)) {
                $allHaveError = false;
                break; // Hentikan loop segera setelah key tidak ditemukan
            }
        }
        if ($allHaveError) {
            return [
                [
                    'error' => 'Not Found',
                    'message' => 'Tidak ada data yang ditemukan',   
                ],
            ];
        }
        return $this->products;
    }
}
