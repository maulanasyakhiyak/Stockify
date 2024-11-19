<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStockView extends Model
{
    protected $table = 'product_stock_view'; // Nama view di database
    public $timestamps = false; // Karena ini adalah view, tidak ada timestamps
}
