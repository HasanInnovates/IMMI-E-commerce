<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'status' => true],
            ['name' => 'Clothing', 'slug' => 'clothing', 'status' => true],
            ['name' => 'Books', 'slug' => 'books', 'status' => true],
            ['name' => 'Home & Garden', 'slug' => 'home-garden', 'status' => true],
            ['name' => 'Sports', 'slug' => 'sports', 'status' => true],
            ['name' => 'Toys & Games', 'slug' => 'toys-games', 'status' => true],
            ['name' => 'Beauty & Health', 'slug' => 'beauty-health', 'status' => true],
            ['name' => 'Automotive', 'slug' => 'automotive', 'status' => true],
            ['name' => 'Music', 'slug' => 'music', 'status' => true],
            ['name' => 'Movies & TV', 'slug' => 'movies-tv', 'status' => true],
            ['name' => 'Pet Supplies', 'slug' => 'pet-supplies', 'status' => true],
            ['name' => 'Office Products', 'slug' => 'office-products', 'status' => true],
            ['name' => 'Food & Grocery', 'slug' => 'food-grocery', 'status' => true],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
