@extends('layouts.app')

@section('title', 'Dashboard Staff')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary mb-2">Dashboard Staff</h1>
        <p class="text-gray-600">Kelola barang dan lelang</p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-blue-500 rounded-lg p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Barang</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Item::count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-green-500 rounded-lg p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Lelang Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Auction::where('status', 'open')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-yellow-500 rounded-lg p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Auction::where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-red-500 rounded-lg p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Auction::where('status', 'closed')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-primary mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('staff.items.create') }}" 
                   class="flex items-center p-3 rounded-lg border border-gray-200 hover:border-accent hover:bg-gray-50 transition-colors">
                    <div class="bg-accent rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Tambah Barang Baru</p>
                        <p class="text-sm text-gray-500">Upload barang untuk dilelang</p>
                    </div>
                </a>

                <a href="{{ route('staff.auctions.create') }}" 
                   class="flex items-center p-3 rounded-lg border border-gray-200 hover:border-accent hover:bg-gray-50 transition-colors">
                    <div class="bg-accent rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 8v8l4-4-4-4zM8 12l4 4 4-4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Buat Lelang Baru</p>
                        <p class="text-sm text-gray-500">Jadwalkan lelang untuk barang</p>
                    </div>
                </a>

                <a href="{{ route('staff.items.index') }}" 
                   class="flex items-center p-3 rounded-lg border border-gray-200 hover:border-accent hover:bg-gray-50 transition-colors">
                    <div class="bg-accent rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Kelola Barang</p>
                        <p class="text-sm text-gray-500">Edit dan hapus barang</p>
                    </div>
                </a>

                <a href="{{ route('staff.auctions.index') }}" 
                   class="flex items-center p-3 rounded-lg border border-gray-200 hover:border-accent hover:bg-gray-50 transition-colors">
                    <div class="bg-accent rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0l4-4-4-4m4 4H5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Kelola Lelang</p>
                        <p class="text-sm text-gray-500">Monitor dan tutup lelang</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Auctions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-primary mb-4">Lelang Terbaru</h3>
            @php
                $recentAuctions = \App\Models\Auction::with(['item', 'bids'])
                    ->latest()
                    ->take(5)
                    ->get();
            @endphp
            
            @if($recentAuctions->count() > 0)
                <div class="space-y-3">
                    @foreach($recentAuctions as $auction)
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $auction->item->image_url }}" 
                                     alt="{{ $auction->item->name }}" 
                                     class="w-12 h-12 object-cover rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">{{ Str::limit($auction->item->name, 30) }}</p>
                                    <p class="text-xs text-gray-500">{{ $auction->bids->count() }} penawaran</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="status-badge status-{{ $auction->status }} text-xs">
                                    {{ ucfirst($auction->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('staff.auctions.index') }}" 
                       class="text-accent hover:text-accent font-medium text-sm">
                        Lihat Semua →
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada lelang</p>
            @endif
        </div>
    </div>

    <!-- Active Auctions Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-primary">Lelang Aktif</h3>
        </div>
        
        @php
            $activeAuctions = \App\Models\Auction::with(['item', 'bids'])
                ->where('status', 'open')
                ->latest()
                ->take(10)
                ->get();
        @endphp
        
        @if($activeAuctions->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Barang
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga Saat Ini
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Penawaran
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Berakhir
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($activeAuctions as $auction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img src="{{ $auction->item->image_url }}" 
                                             alt="{{ $auction->item->name }}" 
                                             class="w-10 h-10 object-cover rounded-lg mr-3">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ Str::limit($auction->item->name, 40) }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $auction->item->category->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-accent">
                                        {{ $auction->formatted_current_bid }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $auction->bids->count() }} penawaran</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 countdown-timer"
                                         x-data="countdown('{{ $auction->end_time->toISOString() }}')"
                                         x-text="timeString">
                                        Loading...
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('staff.auctions.show', $auction) }}" 
                                       class="text-accent hover:text-accent">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-6 text-center">
                <p class="text-gray-500">Tidak ada lelang aktif saat ini</p>
            </div>
        @endif
    </div>
</div>

<script>
function countdown(endTime) {
    return {
        timeString: 'Loading...',
        timer: null,
        
        init() {
            this.updateCountdown();
            this.timer = setInterval(() => {
                this.updateCountdown();
            }, 1000);
        },
        
        updateCountdown() {
            const now = new Date().getTime();
            const end = new Date(endTime).getTime();
            const difference = end - now;
            
            if (difference > 0) {
                const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                
                if (days > 0) {
                    this.timeString = `${days}h ${hours}j`;
                } else if (hours > 0) {
                    this.timeString = `${hours}j ${minutes}m`;
                } else {
                    this.timeString = `${minutes}m`;
                }
            } else {
                this.timeString = 'Berakhir';
                if (this.timer) {
                    clearInterval(this.timer);
                }
            }
        }
    }
}
</script>
@endsection
