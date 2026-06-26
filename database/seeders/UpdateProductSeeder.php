<?php

namespace Database\Seeders;  // ← tambahkan ini!

use App\Models\Product;
use Illuminate\Database\Seeder;

class UpdateProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::whereNull('rating')
                        ->orWhere('rating', 0)
                        ->get();

        foreach ($products as $product) {
            $product->update(
                Product::factory()->withRating()->make()->only(['rating', 'review_count'])
            );
        }

        $this->command->info("ProductSeeder: {$products->count()} produk berhasil diupdate rating & review_count.");
    }
}