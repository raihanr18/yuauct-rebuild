<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = Item::all();
        $staff = User::where('role', 'staff')->first();
        $users = User::where('role', 'user')->get();
        
        foreach ($items as $item) {
            $startTime = now()->subHours(rand(1, 6));
            $endTime = now()->addHours(rand(6, 48));
            
            $auction = Auction::create([
                'item_id' => $item->id,
                'staff_id' => $staff->id,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => 'open',
            ]);
            
            // Add some random bids
            $bidCount = rand(2, 8);
            $currentPrice = $item->start_price;
            
            for ($i = 0; $i < $bidCount; $i++) {
                $bidAmount = $currentPrice + rand(50000, 200000);
                $user = $users->random();
                
                Bid::create([
                    'auction_id' => $auction->id,
                    'user_id' => $user->id,
                    'bid_amount' => $bidAmount,
                    'created_at' => $startTime->copy()->addMinutes(rand(10, 300)),
                ]);
                
                $currentPrice = $bidAmount;
            }
        }
    }
}
