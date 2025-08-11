<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Laptop ASUS',
                'description' => 'Laptop gaming dengan spesifikasi tinggi',
                'category_id' => 1,
                'stock' => 25
            ],
            [
                'name' => 'Smartphone Samsung',
                'description' => 'Smartphone flagship terbaru',
                'category_id' => 1,
                'stock' => 15
            ],
            [
                'name' => 'Kemeja Formal',
                'description' => 'Kemeja formal untuk kerja',
                'category_id' => 2,
                'stock' => 8
            ],
            [
                'name' => 'Kopi Arabica',
                'description' => 'Kopi premium dari Aceh',
                'category_id' => 3,
                'stock' => 50
            ],
            [
                'name' => 'Meja Kantor',
                'description' => 'Meja kerja minimalis',
                'category_id' => 4,
                'stock' => 5
            ],
            [
                'name' => 'Pulpen Pilot',
                'description' => 'Pulpen berkualitas tinggi',
                'category_id' => 5,
                'stock' => 100
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}