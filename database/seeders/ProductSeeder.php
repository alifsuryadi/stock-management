<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; // Pastikan facade ini di-import
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Panggil fungsi untuk menyalin gambar lokal terlebih dahulu
        $this->copyLocalImages();

        // Data produk (tanpa path gambar, karena akan dibuat otomatis)
        $productsData = [
            [
                'name' => 'Laptop ASUS ROG',
                'description' => 'Laptop gaming dengan spesifikasi tinggi, processor Intel i9, RAM 16GB, VGA RTX 4060',
                'category_id' => 1, 'stock' => 25,
            ],
            [
                'name' => 'Smartphone Samsung Galaxy S23',
                'description' => 'Smartphone flagship terbaru dengan kamera 108MP, display AMOLED 6.7 inch',
                'category_id' => 1, 'stock' => 15,
            ],
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'iPhone terbaru dengan chip A17 Pro, kamera 48MP, storage 256GB',
                'category_id' => 1, 'stock' => 8,
            ],
            [
                'name' => 'Kemeja Formal Premium',
                'description' => 'Kemeja formal berkualitas premium untuk kerja, bahan katun 100%',
                'category_id' => 2, 'stock' => 30,
            ],
            [
                'name' => 'Blazer Pria Elegant',
                'description' => 'Blazer pria dengan cutting modern, cocok untuk meeting dan acara formal',
                'category_id' => 2, 'stock' => 12,
            ],
            [
                'name' => 'Kopi Arabica Aceh Gayo',
                'description' => 'Kopi premium dari Aceh Gayo, single origin dengan cita rasa terbaik',
                'category_id' => 3, 'stock' => 50,
            ],
            [
                'name' => 'Green Tea Organic',
                'description' => 'Teh hijau organik premium dari perkebunan terpilih',
                'category_id' => 3, 'stock' => 35,
            ],
            [
                'name' => 'Meja Kantor Minimalis',
                'description' => 'Meja kerja minimalis dengan desain modern, bahan kayu solid',
                'category_id' => 4, 'stock' => 5,
            ],
            [
                'name' => 'Kursi Ergonomis Executive',
                'description' => 'Kursi kantor ergonomis dengan bantalan memory foam untuk kenyamanan maksimal',
                'category_id' => 4, 'stock' => 10,
            ],
            [
                'name' => 'Pulpen Pilot Premium',
                'description' => 'Pulpen berkualitas tinggi dengan tinta smooth writing',
                'category_id' => 5, 'stock' => 100,
            ],
            [
                'name' => 'Notebook Moleskine',
                'description' => 'Notebook premium dengan cover kulit dan kertas berkualitas tinggi',
                'category_id' => 5, 'stock' => 45,
            ]
        ];

        foreach ($productsData as $product) {
            // Buat nama file dari nama produk (contoh: 'Laptop ASUS ROG' -> 'laptop-asus-rog.jpg')
            $imageFileName = Str::slug($product['name']) . '.jpg';
            
            // Tambahkan path gambar ke data produk sebelum membuat record di database
            $product['image'] = 'products/' . $imageFileName;

            Product::create($product);
        }
    }

    /**
     * Menyalin gambar dari direktori seeder lokal ke storage publik.
     */
    private function copyLocalImages()
    {
        // 1. Definisikan path sumber dan tujuan
        $sourceDir = database_path('seeders/images');
        $destinationDir = 'products';

        // 2. Pastikan direktori tujuan ada di storage
        if (!Storage::disk('public')->exists($destinationDir)) {
            Storage::disk('public')->makeDirectory($destinationDir);
        }

        // 3. Ambil semua file dari direktori sumber
        $files = File::files($sourceDir);

        $this->command->info("Starting to copy local images...");

        foreach ($files as $file) {
            $filename = $file->getFilename();
            $destinationPath = $destinationDir . '/' . $filename;
            
            // Cek jika file sudah ada, lewati agar tidak kerja dua kali
            if (Storage::disk('public')->exists($destinationPath)) {
                $this->command->warn("Image already exists, skipping: {$filename}");
                continue;
            }

            // 4. Salin file ke direktori tujuan
            Storage::disk('public')->put($destinationPath, $file->getContents());
            $this->command->line("  - Copied {$filename}");
        }

        $this->command->info("Image copying complete. ✨");
    }
}