<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Item;

class SampleItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keramikCat = Category::where('name', 'Keramik')->first();
        $patungCat = Category::where('name', 'Patung')->first();
        $perhiasanCat = Category::where('name', 'Perhiasan')->first();

        if (!$keramikCat || !$patungCat || !$perhiasanCat) {
            $this->command->error('Categories not found. Please run CategorySeeder first.');
            return;
        }

        $items = [
            [
                'name' => 'Mangkuk Antik Keramik',
                'description' => 'Mangkuk keramik antik dengan motif tradisional yang indah. Kondisi sangat baik dan terawat.',
                'start_price' => 250000,
                'category_id' => $keramikCat->id,
                'image' => 'mangkukAntik.jpg'
            ],
            [
                'name' => 'Patung Budha Antik',
                'description' => 'Patung Budha antik terbuat dari perunggu dengan detail yang sangat halus. Tinggi 25cm.',
                'start_price' => 500000,
                'category_id' => $patungCat->id,
                'image' => 'patungAntik.JPG'
            ],
            [
                'name' => 'Cincin Emas Antik',
                'description' => 'Cincin emas 22 karat dengan batu permata asli. Desain klasik yang elegan.',
                'start_price' => 750000,
                'category_id' => $perhiasanCat->id,
                'image' => 'cincinAntik.jpg'
            ],
            [
                'name' => 'Gelang Perak Antik',
                'description' => 'Gelang perak murni dengan ukiran tradisional. Cocok untuk kolektor perhiasan antik.',
                'start_price' => 300000,
                'category_id' => $perhiasanCat->id,
                'image' => 'gelangAntik.jpg'
            ],
            [
                'name' => 'Jam Antik Klasik',
                'description' => 'Jam saku antik dengan mesin mekanik yang masih berfungsi dengan baik.',
                'start_price' => 1000000,
                'category_id' => $perhiasanCat->id,
                'image' => 'jamAntik.jpg'
            ]
        ];

        foreach ($items as $itemData) {
            Item::firstOrCreate(
                ['name' => $itemData['name']],
                $itemData
            );
        }

        $this->command->info('Sample items created successfully!');
    }
}
