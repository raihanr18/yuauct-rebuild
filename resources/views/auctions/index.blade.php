@extends('layouts.app')

@section('title', 'Daftar Lelang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary mb-4">Daftar Lelang</h1>
        <p class="text-gray-600">Temukan dan ikuti lelang barang antik favorit Anda</p>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('auctions.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Barang</label>
                    <input type="text" 
                           name="search" 
                           id="search"
                           value="{{ request('search') }}"
                           placeholder="Masukkan nama barang..."
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-accent focus:ring-accent">
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category" 
                            id="category"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-accent focus:ring-accent">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                    <select name="sort" 
                            id="sort"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-accent focus:ring-accent">
                        <option value="ending_soon" {{ request('sort') == 'ending_soon' ? 'selected' : '' }}>Segera Berakhir</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full">
                        Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Auction Grid -->
    @if($auctions->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($auctions as $auction)
                <div class="auction-card">
                    <div class="relative">
                        <img src="{{ $auction->item->image_url }}" 
                             alt="{{ $auction->item->name }}" 
                             class="w-full h-48 object-cover">
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="status-badge status-{{ $auction->status }}">
                                @if($auction->status === 'open')
                                    Berlangsung
                                @elseif($auction->status === 'pending')
                                    Menunggu
                                @else
                                    Berakhir
                                @endif
                            </span>
                        </div>

                        <!-- Time Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs countdown-timer"
                                  x-data="countdown('{{ $auction->end_time->toISOString() }}')"
                                  x-text="timeString">
                                Loading...
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-semibold text-primary line-clamp-1">
                                    {{ $auction->item->name }}
                                </h3>
                                <span class="text-xs text-gray-500 ml-2">
                                    {{ $auction->item->category->name }}
                                </span>
                            </div>
                        </div>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ Str::limit($auction->item->description, 80) }}
                        </p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Harga Saat Ini:</span>
                                <span class="bid-amount text-sm">{{ $auction->formatted_current_bid }}</span>
                            </div>
                            
                            @if($auction->bids->count() > 0)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Total Bidder:</span>
                                    <span class="text-sm font-medium">{{ $auction->bids->count() }} orang</span>
                                </div>
                            @endif
                        </div>
                        
                        <a href="{{ route('auctions.show', $auction) }}" 
                           class="btn-primary w-full text-center text-sm">
                            @if($auction->isActive())
                                Ikut Lelang
                            @else
                                Lihat Detail
                            @endif
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $auctions->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.5-.586-6.26-1.626M16 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada lelang ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(request()->hasAny(['search', 'category', 'sort']))
                        Coba ubah filter pencarian Anda.
                    @else
                        Belum ada lelang yang tersedia saat ini.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'category', 'sort']))
                    <div class="mt-6">
                        <a href="{{ route('auctions.index') }}" class="btn-secondary">
                            Reset Filter
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif
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
                const seconds = Math.floor((difference % (1000 * 60)) / 1000);
                
                if (days > 0) {
                    this.timeString = `${days}h ${hours}j`;
                } else if (hours > 0) {
                    this.timeString = `${hours}j ${minutes}m`;
                } else {
                    this.timeString = `${minutes}m ${seconds}d`;
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
