<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word, // Nama kategori acak
            'description' => $this->faker->sentence, // Deskripsi acak
        ];
    }
}
