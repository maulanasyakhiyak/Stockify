<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ["name" => "Laptop Pro Series", "category" => "Electronics"],
            ["name" => "Smartphone Ultra", "category" => "Electronics"],
            ["name" => "Tablet Lite", "category" => "Electronics"],
            ["name" => "Gaming Headset", "category" => "Accessories"],
            ["name" => "Wireless Earbuds", "category" => "Accessories"],
            ["name" => "Smartwatch Fit", "category" => "Wearables"],
            ["name" => "Bluetooth Speaker", "category" => "Audio"],
            ["name" => "Keyboard Mechanical", "category" => "Accessories"],
            ["name" => "Gaming Mouse", "category" => "Accessories"],
            ["name" => "4K Monitor", "category" => "Electronics"],
            ["name" => "External SSD", "category" => "Storage"],
            ["name" => "Power Bank", "category" => "Accessories"],
            ["name" => "Smart TV 55 inch", "category" => "Home Appliances"],
            ["name" => "WiFi Router", "category" => "Networking"],
            ["name" => "Digital Camera", "category" => "Photography"],
            ["name" => "Tripod Stand", "category" => "Accessories"],
            ["name" => "Lens Kit", "category" => "Photography"],
            ["name" => "Drone Pro", "category" => "Gadgets"],
            ["name" => "Action Camera", "category" => "Photography"],
            ["name" => "VR Headset", "category" => "Gadgets"],
            ["name" => "Electric Scooter", "category" => "Transportation"],
            ["name" => "E-Bike", "category" => "Transportation"],
            ["name" => "Home Theater", "category" => "Audio"],
            ["name" => "Air Purifier", "category" => "Home Appliances"],
            ["name" => "Coffee Maker", "category" => "Kitchen"],
            ["name" => "Blender Pro", "category" => "Kitchen"],
            ["name" => "Microwave Oven", "category" => "Kitchen"],
            ["name" => "Refrigerator 2-door", "category" => "Home Appliances"],
            ["name" => "Washing Machine", "category" => "Home Appliances"],
            ["name" => "Smart Air Conditioner", "category" => "Home Appliances"],
            ["name" => "Vacuum Cleaner", "category" => "Home Appliances"],
            ["name" => "Robot Vacuum", "category" => "Home Appliances"],
            ["name" => "Gaming Chair", "category" => "Furniture"],
            ["name" => "Office Desk", "category" => "Furniture"],
            ["name" => "LED Desk Lamp", "category" => "Lighting"],
            ["name" => "3D Printer", "category" => "Gadgets"],
            ["name" => "Smart Door Lock", "category" => "Home Security"],
            ["name" => "Security Camera", "category" => "Home Security"],
            ["name" => "Smoke Detector", "category" => "Home Security"],
            ["name" => "Fitness Tracker", "category" => "Wearables"],
            ["name" => "Yoga Mat", "category" => "Fitness"],
            ["name" => "Dumbbell Set", "category" => "Fitness"],
            ["name" => "Running Shoes", "category" => "Fitness"],
            ["name" => "Sports Water Bottle", "category" => "Accessories"],
            ["name" => "Backpack Travel", "category" => "Travel"],
            ["name" => "Suitcase Spinner", "category" => "Travel"],
            ["name" => "Portable Charger", "category" => "Accessories"],
            ["name" => "Electric Kettle", "category" => "Kitchen"],
            ["name" => "Hair Dryer", "category" => "Personal Care"],
            ["name" => "Shaving Kit", "category" => "Personal Care"],
            ["name" => "Beauty Mirror", "category" => "Personal Care"],
        ];

        $categories = collect($products)->pluck('category')->unique();
        $categoryMap = [];
        foreach ($categories as $categoryName) {
            $category = Category::factory()->create(['name' => $categoryName]);
            $categoryMap[$categoryName] = $category->id; // Simpan ID kategori
        }

        $increment = 1;
        foreach ($products as $product) {
            $sku = strtoupper(substr($product['category'], 0, 4)) . str_pad($increment, 4, '0', STR_PAD_LEFT);
            $increment ++;
            Product::factory()->create([
                'name' => $product['name'],
                'sku' => $sku,
                'category_id' => $categoryMap[$product['category']], // Ambil ID kategori dari map
            ]);
        }
        Supplier::factory()->count(5)->create();
    }
}
