<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        $products = [
            [
                'name' => 'Laptop Computer',
                'description' => 'High-performance laptop for work and gaming',
                'price' => 49999.00,
                'quantity' => 15,
                'sku' => 'LAPTOP-001',
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with USB receiver',
                'price' => 599.00,
                'quantity' => 50,
                'sku' => 'MOUSE-001',
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
            ],
            [
                'name' => 'Cotton T-Shirt',
                'description' => 'Comfortable cotton t-shirt in various sizes',
                'price' => 299.00,
                'quantity' => 100,
                'sku' => 'TSHIRT-001',
                'category_id' => $categories->where('name', 'Clothing')->first()->id,
            ],
            [
                'name' => 'Programming Book',
                'description' => 'Complete guide to web development',
                'price' => 1299.00,
                'quantity' => 25,
                'sku' => 'BOOK-001',
                'category_id' => $categories->where('name', 'Books')->first()->id,
            ],
            [
                'name' => 'Garden Hose',
                'description' => '50ft expandable garden hose with spray nozzle',
                'price' => 799.00,
                'quantity' => 30,
                'sku' => 'GARDEN-001',
                'category_id' => $categories->where('name', 'Home & Garden')->first()->id,
            ],
            [
                'name' => 'Basketball',
                'description' => 'Official size basketball for indoor and outdoor use',
                'price' => 899.00,
                'quantity' => 20,
                'sku' => 'SPORT-001',
                'category_id' => $categories->where('name', 'Sports')->first()->id,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['sku' => $product['sku']], $product);
        }
    }
}
