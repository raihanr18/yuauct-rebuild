<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        
        // Copy images from old project to storage
        $this->copyImages();
        
        $items = [
            [
                'name' => 'Mangkuk Keramik Antik',
                'description' => 'Mangkuk keramik antik dengan motif tradisional yang indah. Dibuat pada era dinasti Ming dengan kualitas keramik yang sangat halus dan detail ornamen yang menawan.',
                'image' => 'mangkukAntik.jpg',
                'start_price' => 500000,
                'category_id' => $categories->where('slug', 'keramik-antik')->first()->id,
            ],
            [
                'name' => 'Patung Antik Tradisional',
                'description' => 'Patung antik dengan nilai sejarah tinggi. Terbuat dari batu alam dengan ukiran detail yang menggambarkan sosok tokoh legendaris dari zaman kuno.',
                'image' => 'patungAntik.JPG',
                'start_price' => 1500000,
                'category_id' => $categories->where('slug', 'patung-antik')->first()->id,
            ],
            [
                'name' => 'Cincin Emas Antik',
                'description' => 'Cincin emas antik dengan batu permata asli. Desain klasik yang elegan dengan craftsmanship tinggi dari era Victoria.',
                'image' => 'cincinAntik.jpg',
                'start_price' => 2000000,
                'category_id' => $categories->where('slug', 'perhiasan-antik')->first()->id,
            ],
            [
                'name' => 'Gelang Perak Antik',
                'description' => 'Gelang perak antik dengan ukiran rumit dan detail yang sangat halus. Merupakan perhiasan tradisional dengan nilai historis yang tinggi.',
                'image' => 'gelangAntik.jpg',
                'start_price' => 750000,
                'category_id' => $categories->where('slug', 'perhiasan-antik')->first()->id,
            ],
            [
                'name' => 'Jam Saku Antik',
                'description' => 'Jam saku antik mekanik yang masih berfungsi dengan baik. Casing emas dengan chain asli, merupakan koleksi langka dari awal abad ke-20.',
                'image' => 'jamAntik.jpg',
                'start_price' => 3000000,
                'category_id' => $categories->where('slug', 'koleksi-langka')->first()->id,
            ],
        ];

        foreach ($items as $itemData) {
            Item::create($itemData);
        }
    }
    
    private function copyImages()
    {
        $sourcePath = base_path('ujikomPaket4-raihan-master-lama/img/');
        $destinationPath = storage_path('app/public/items/');
        
        // Create destination directory if it doesn't exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        
        $images = [
            'mangkukAntik.jpg',
            'patungAntik.JPG',
            'cincinAntik.jpg',
            'gelangAntik.jpg',
            'jamAntik.jpg',
        ];
        
        foreach ($images as $image) {
            $source = $sourcePath . $image;
            $destination = $destinationPath . $image;
            
            if (file_exists($source) && !file_exists($destination)) {
                copy($source, $destination);
            }
        }
    }
}
