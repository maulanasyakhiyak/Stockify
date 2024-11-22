<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'sku' => $this->faker->unique()->word,
            'purchase_price' => $this->faker->numberBetween(1, 100) * 1000,
            'selling_price' => $this->faker->numberBetween(2, 200) * 1000,
            'description' => $this->faker->sentence,
            'category_id' => $this->faker->randomElement(\App\Models\Category::pluck('id')->toArray()), // Ambil ID kategori yang ada
            'supplier_id' => $this->faker->randomElement(\App\Models\Supplier::pluck('id')->toArray()), // Ambil ID supplier yang ada
        ];
    }
}
