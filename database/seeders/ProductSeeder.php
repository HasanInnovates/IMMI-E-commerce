<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $electronicsId = Category::where('slug', 'electronics')->value('id');
        $clothingId = Category::where('slug', 'clothing')->value('id');
        $booksId = Category::where('slug', 'books')->value('id');
        $homeId = Category::where('slug', 'home-garden')->value('id');
        $sportsId = Category::where('slug', 'sports')->value('id');

        $products = [
            ['category_id' => $electronicsId, 'name' => 'Smartphone', 'slug' => 'smartphone', 'description' => 'Latest model smartphone with high-resolution camera and fast processor.', 'price' => 699.99, 'stock' => 50, 'status' => true],
            ['category_id' => $electronicsId, 'name' => 'Laptop', 'slug' => 'laptop', 'description' => 'Lightweight laptop with 16GB RAM and 512GB SSD.', 'price' => 1299.99, 'stock' => 30, 'status' => true],
            ['category_id' => $electronicsId, 'name' => 'Wireless Headphones', 'slug' => 'wireless-headphones', 'description' => 'Noise-cancelling wireless headphones with 30-hour battery life.', 'price' => 199.99, 'stock' => 100, 'status' => true],
            ['category_id' => $clothingId, 'name' => 'Cotton T-Shirt', 'slug' => 'cotton-tshirt', 'description' => 'Comfortable 100% cotton t-shirt available in multiple colors.', 'price' => 24.99, 'stock' => 200, 'status' => true],
            ['category_id' => $clothingId, 'name' => 'Denim Jacket', 'slug' => 'denim-jacket', 'description' => 'Classic denim jacket with modern fit.', 'price' => 89.99, 'stock' => 75, 'status' => true],
            ['category_id' => $booksId, 'name' => 'Laravel: The Complete Guide', 'slug' => 'laravel-complete-guide', 'description' => 'Comprehensive guide to building modern web applications with Laravel.', 'price' => 49.99, 'stock' => 150, 'status' => true],
            ['category_id' => $booksId, 'name' => 'Design Patterns in PHP', 'slug' => 'design-patterns-php', 'description' => 'Learn modern design patterns and best practices in PHP.', 'price' => 39.99, 'stock' => 120, 'status' => true],
            ['category_id' => $homeId, 'name' => 'Table Lamp', 'slug' => 'table-lamp', 'description' => 'Modern LED table lamp with adjustable brightness.', 'price' => 45.99, 'stock' => 60, 'status' => true],
            ['category_id' => $homeId, 'name' => 'Throw Blanket', 'slug' => 'throw-blanket', 'description' => 'Soft microfiber throw blanket, machine washable.', 'price' => 34.99, 'stock' => 0, 'status' => true],
            ['category_id' => $sportsId, 'name' => 'Yoga Mat', 'slug' => 'yoga-mat', 'description' => 'Non-slip exercise yoga mat with carrying strap.', 'price' => 29.99, 'stock' => 5, 'status' => true],
            ['category_id' => $sportsId, 'name' => 'Dumbbell Set', 'slug' => 'dumbbell-set', 'description' => 'Adjustable dumbbell set 2x10kg.', 'price' => 79.99, 'stock' => 20, 'status' => false],
            ['category_id' => $electronicsId, 'name' => 'Bluetooth Speaker', 'slug' => 'bluetooth-speaker', 'description' => 'Portable waterproof bluetooth speaker with 12h battery.', 'price' => 59.99, 'stock' => 3, 'status' => true],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
