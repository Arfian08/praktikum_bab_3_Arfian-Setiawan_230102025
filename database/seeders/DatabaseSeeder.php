<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;


Review::factory(300)->create();
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            UpdateProductSeeder::class,
        ]);
    }
}