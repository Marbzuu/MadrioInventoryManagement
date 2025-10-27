<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and accessories',
            ],
            [
                'name' => 'Clothing',
                'description' => 'Apparel and fashion items',
            ],
            [
                'name' => 'Books',
                'description' => 'Books and educational materials',
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home improvement and garden supplies',
            ],
            [
                'name' => 'Sports',
                'description' => 'Sports equipment and accessories',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
