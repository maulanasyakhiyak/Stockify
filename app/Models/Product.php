<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'sku',
        'minimal_stock',
        'description',
        'purchase_price',
        'selling_price',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }
    public function stock()
    {
        return $this->hasOne(ProductStock::class);
    }
}
