<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockTransaction>
 */
class StockTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id, // Mengambil ID produk secara acak
            'user_id' => User::inRandomOrder()->first()->id,       // Mengambil ID user secara acak
            'type' => $this->faker->randomElement(['in', 'out']),  // Nilai acak untuk tipe transaksi
            'quantity' => $this->faker->numberBetween(1, 100),     // Nilai acak untuk kuantitas
            'date' => $this->faker->dateTimeBetween('2023-01-01', '2024-12-31')->format('Y-m-d'),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']), // Contoh status
            'notes' => $this->faker->optional()->sentence(),       // Catatan opsional
        ];
    }
}
