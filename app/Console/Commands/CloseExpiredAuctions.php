<?php

namespace App\Console\Commands;

use App\Models\Auction;
use Illuminate\Console\Command;

class CloseExpiredAuctions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auctions:close-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close expired auctions and determine winners';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredAuctions = Auction::where('status', 'open')
            ->where('end_time', '<=', now())
            ->get();

        if ($expiredAuctions->isEmpty()) {
            $this->info('No expired auctions found.');
            return;
        }

        $closedCount = 0;

        foreach ($expiredAuctions as $auction) {
            $highestBid = $auction->bids()->orderBy('bid_amount', 'desc')->first();

            if ($highestBid) {
                $auction->update([
                    'status' => 'closed',
                    'final_price' => $highestBid->bid_amount,
                    'winner_id' => $highestBid->user_id,
                ]);
                
                $this->info("Auction ID {$auction->id} closed. Winner: {$highestBid->user->name} with bid: Rp " . number_format($highestBid->bid_amount, 0, ',', '.'));
            } else {
                $auction->update(['status' => 'closed']);
                $this->info("Auction ID {$auction->id} closed with no bids.");
            }

            $closedCount++;
        }

        $this->info("Total {$closedCount} auctions closed.");
    }
}
