<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = json_decode(file_get_contents(database_path('data/products.json')), true);
    foreach ($products as $product) {
        \App\Models\Product::create([
            'id' => $product['id'],
            'name' => $product['name'] ?? null,
            'description' => $product['description'] ?? null,
            'category' => $product['category'],
            'price' => $product['price'],
            'stock' => $product['stock'],
        ]);
    }
    }
}
