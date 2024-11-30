<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $defaultSKU = 'DEFAULT-'. rand(1000, 9999);
        while(Product::where('sku', $defaultSKU)->exists()){
            $defaultSKU = 'DEFAULT-'. rand(1000, 9999);
        }
        return [
            'name' => $this->faker->word,
            'sku' => $defaultSKU,
            'purchase_price' => $this->faker->numberBetween(1, 100) * 1000,
            'selling_price' => $this->faker->numberBetween(2, 200) * 1000,
            'description' => $this->faker->sentence,
            'supplier_id' => $this->faker->randomElement(\App\Models\Supplier::pluck('id')->toArray()), // Ambil ID supplier yang ada
        ];
    }
}
