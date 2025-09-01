<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ['name' => 'Keramik Antik', 'slug' => 'keramik-antik'],
            ['name' => 'Patung Antik', 'slug' => 'patung-antik'],
            ['name' => 'Perhiasan Antik', 'slug' => 'perhiasan-antik'],
            ['name' => 'Lukisan', 'slug' => 'lukisan'],
            ['name' => 'Perabotan Antik', 'slug' => 'perabotan-antik'],
            ['name' => 'Koleksi Langka', 'slug' => 'koleksi-langka'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
