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
            'purchase_price' => $this->faker->randomFloat(2, 10, 100),
            'selling_price' => $this->faker->randomFloat(2, 100, 200),
            'description' => $this->faker->sentence,
            'image' => $this->faker->imageUrl(50, 50, 'animals', true, 'cats'),
            'category_id' => $this->faker->randomElement(\App\Models\Category::pluck('id')->toArray()), // Ambil ID kategori yang ada
            'supplier_id' => $this->faker->randomElement(\App\Models\Supplier::pluck('id')->toArray()), // Ambil ID supplier yang ada
        ];
    }
}
