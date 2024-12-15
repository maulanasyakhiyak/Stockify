<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StockTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StockTransaction::factory()->count(50)->create();
    }
}
