<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Auction;
use App\Models\Item;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard with comprehensive analytics
     */
    public function index()
    {
        // User Statistics
        $userStats = [
            'total' => User::count(),
            'active' => User::where('status', 'active')->count(),
            'suspended' => User::where('status', 'suspended')->count(),
            'new_this_month' => User::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        // Role Distribution
        $roleStats = User::select('role', DB::raw('count(*) as count'))
                        ->groupBy('role')
                        ->pluck('count', 'role')
                        ->toArray();

        // Auction Statistics
        $auctionStats = [
            'total' => Auction::count(),
            'active' => Auction::where('status', 'active')->count(),
            'completed' => Auction::where('status', 'closed')->count(),
            'pending' => Auction::where('status', 'pending')->count(),
        ];

        // Revenue Analytics (if applicable)
        $revenueStats = [
            'total_bids' => Bid::count(),
            'total_bid_value' => Bid::sum('bid_amount'),
            'avg_bid' => Bid::avg('bid_amount'),
            'this_month_bids' => Bid::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        // Recent Activities
        $recentUsers = User::latest()->take(5)->get();
        $recentAuctions = Auction::with('item')->latest()->take(5)->get();
        $recentBids = Bid::with(['user', 'auction.item'])->latest()->take(10)->get();

        // System Health Indicators
        $systemHealth = [
            'server_time' => now()->format('Y-m-d H:i:s T'),
            'laravel_version' => app()->version(),
            'php_version' => PHP_VERSION,
            'database_connection' => $this->checkDatabaseConnection(),
        ];

        return view('admin.dashboard', compact(
            'userStats',
            'roleStats', 
            'auctionStats',
            'revenueStats',
            'recentUsers',
            'recentAuctions',
            'recentBids',
            'systemHealth'
        ));
    }

    /**
     * Check database connection health
     */
    private function checkDatabaseConnection(): string
    {
        try {
            DB::connection()->getPdo();
            return 'Connected';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
