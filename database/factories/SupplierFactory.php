<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,          // Nama perusahaan supplier acak
            'address' => $this->faker->address,       // Alamat acak
            'phone' => $this->faker->phoneNumber,     // Nomor telepon acak
            'email' => $this->faker->unique()->safeEmail, // Email acak dan unik
        ];
    }
}
