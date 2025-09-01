<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Item;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use Carbon\Carbon;

class AuctionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories if they don't exist
        $categories = [
            ['name' => 'Antique Furniture', 'slug' => 'antique-furniture'],
            ['name' => 'Artwork', 'slug' => 'artwork'],
            ['name' => 'Jewelry', 'slug' => 'jewelry'],
            ['name' => 'Collectibles', 'slug' => 'collectibles'],
            ['name' => 'Electronics', 'slug' => 'electronics'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['name' => $categoryData['name']], 
                $categoryData
            );
        }

        // Get admin/staff users
        $adminUsers = User::whereIn('role', ['admin', 'staff'])->get();
        $staffUser = $adminUsers->first();

        if (!$staffUser) {
            echo "No admin/staff users found. Please run AdminUserSeeder first.\n";
            return;
        }

        // Create items
        $items = [
            [
                'name' => 'Antique Victorian Chair',
                'description' => 'Beautiful mahogany Victorian chair from the 1800s with intricate carvings.',
                'start_price' => 500000,
                'category_id' => Category::where('name', 'Antique Furniture')->first()->id,
                'image' => 'items/patungAntik.JPG'
            ],
            [
                'name' => 'Vintage Oil Painting',
                'description' => 'Original oil painting depicting a countryside landscape.',
                'start_price' => 750000,
                'category_id' => Category::where('name', 'Artwork')->first()->id,
                'image' => 'items/mangkukAntik.jpg'
            ],
            [
                'name' => 'Gold Pocket Watch',
                'description' => '18k gold pocket watch from 1920s in excellent condition.',
                'start_price' => 1200000,
                'category_id' => Category::where('name', 'Jewelry')->first()->id,
                'image' => 'items/jamAntik.jpg'
            ],
            [
                'name' => 'Vintage Ceramic Vase',
                'description' => 'Hand-painted ceramic vase from Ming dynasty replica.',
                'start_price' => 300000,
                'category_id' => Category::where('name', 'Collectibles')->first()->id,
                'image' => 'items/gelangAntik.jpg'
            ],
            [
                'name' => 'Antique Radio',
                'description' => '1940s vintage radio in working condition.',
                'start_price' => 400000,
                'category_id' => Category::where('name', 'Electronics')->first()->id,
                'image' => 'items/cincinAntik.jpg'
            ],
        ];

        foreach ($items as $itemData) {
            $item = Item::firstOrCreate(
                ['name' => $itemData['name']], 
                $itemData
            );

            // Create auctions for each item
            $statuses = ['pending', 'open', 'closed'];
            $status = $statuses[array_rand($statuses)];
            
            $startTime = Carbon::now()->subDays(rand(1, 30));
            $endTime = $startTime->copy()->addDays(rand(1, 7));

            // Adjust times based on status
            if ($status === 'pending') {
                $startTime = Carbon::now()->addHours(rand(1, 24));
                $endTime = $startTime->copy()->addDays(rand(1, 5));
            } elseif ($status === 'open') {
                $startTime = Carbon::now()->subHours(rand(1, 48));
                $endTime = Carbon::now()->addHours(rand(1, 72));
            } elseif ($status === 'closed') {
                $startTime = Carbon::now()->subDays(rand(1, 30));
                $endTime = $startTime->copy()->addDays(rand(1, 7));
                if ($endTime > Carbon::now()) {
                    $endTime = Carbon::now()->subHours(rand(1, 24));
                }
            }

            $auction = Auction::firstOrCreate([
                'item_id' => $item->id,
                'staff_id' => $staffUser->id,
            ], [
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => $status,
                'final_price' => $status === 'closed' ? $item->start_price + rand(50000, 500000) : null,
            ]);

            // Create some bids for open/closed auctions
            if (in_array($status, ['open', 'closed'])) {
                $regularUsers = User::where('role', 'user')->take(3)->get();
                
                if ($regularUsers->count() === 0) {
                    // Create some dummy users for bidding
                    for ($i = 1; $i <= 3; $i++) {
                        User::firstOrCreate([
                            'email' => "bidder{$i}@example.com"
                        ], [
                            'name' => "Bidder {$i}",
                            'password' => bcrypt('password'),
                            'role' => 'user',
                        ]);
                    }
                    $regularUsers = User::where('role', 'user')->take(3)->get();
                }

                $bidAmount = $item->start_price;
                foreach ($regularUsers as $user) {
                    $bidAmount += rand(25000, 100000);
                    
                    Bid::firstOrCreate([
                        'auction_id' => $auction->id,
                        'user_id' => $user->id,
                        'bid_amount' => $bidAmount,
                    ]);
                }

                // Set winner for closed auctions
                if ($status === 'closed') {
                    $highestBid = $auction->bids()->orderBy('bid_amount', 'desc')->first();
                    if ($highestBid) {
                        $auction->update([
                            'winner_id' => $highestBid->user_id,
                            'final_price' => $highestBid->bid_amount,
                        ]);
                    }
                }
            }
        }

        echo "Auction demo data created successfully!\n";
    }
}
