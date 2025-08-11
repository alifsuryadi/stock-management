<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Produk elektronik dan gadget'
            ],
            [
                'name' => 'Pakaian',
                'description' => 'Pakaian dan fashion'
            ],
            [
                'name' => 'Makanan',
                'description' => 'Produk makanan dan minuman'
            ],
            [
                'name' => 'Furniture',
                'description' => 'Perabotan rumah tangga'
            ],
            [
                'name' => 'Alat Tulis',
                'description' => 'Peralatan kantor dan sekolah'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}