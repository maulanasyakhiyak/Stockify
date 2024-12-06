<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'role' => 'admin'
        ]);
        User::factory()->create([
            'email' => 'manager@example.com',
            'role' => 'manager',
        ]);
        User::factory()->create([
            'email' => 'staff@example.com',
            'role' => 'staff',
        ]);
        $this->call([
            ProductSeeder::class,
            StockTransactionSeeder::class,
        ]);
    }

}
