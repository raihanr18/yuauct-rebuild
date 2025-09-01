@extends('layouts.app')

@section('title', $auction->item->name . ' - Auction')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Item Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Item Image and Basic Info -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="relative">
                    @if($auction->item->image)
                        <img src="{{ asset('storage/' . $auction->item->image) }}" 
                             alt="{{ $auction->item->name }}" 
                             class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Auction Status Badge -->
                    <div class="absolute top-4 left-4">
                        @if($auction->isActive())
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Aktif
                            </span>
                        @elseif($auction->hasEnded())
                            @if($auction->winner_id)
                                <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Terjual
                                </span>
                            @else
                                <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Berakhir
                                </span>
                            @endif
                        @else
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Akan Dimulai
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $auction->item->name }}</h1>
                    
                    <!-- Description Section -->
                    @if($auction->item->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Deskripsi
                            </h3>
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                <p class="text-gray-700 leading-relaxed">{{ $auction->item->description }}</p>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Item Details Grid -->
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Detail Item
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-gray-600 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        Kategori:
                                    </span>
                                    <span class="font-semibold text-accent">
                                        @if(is_object($auction->item->category))
                                            {{ $auction->item->category->name }}
                                        @else
                                            {{ $auction->item->category }}
                                        @endif
                                    </span>
                                </div>
                                
                                @if($auction->item->condition)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <span class="text-gray-600 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Kondisi:
                                        </span>
                                        <span class="font-semibold">{{ $auction->item->condition }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-gray-600 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        Harga Awal:
                                    </span>
                                    <span class="font-semibold text-green-600">
                                        Rp {{ number_format($auction->item->start_price, 0, ',', '.') }}
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Waktu Mulai:
                                    </span>
                                    <span class="font-semibold">{{ \Carbon\Carbon::parse($auction->start_time)->format('d/m/Y H:i') }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Waktu Berakhir:
                                    </span>
                                    <span class="font-semibold">{{ \Carbon\Carbon::parse($auction->end_time)->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Recent Bids History -->
                        @if($auction->bids->count() > 0)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Riwayat Penawaran
                                    <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $auction->bids->count() }}</span>
                                </h3>
                                <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                                    @foreach($auction->bids->take(10) as $bid)
                                        <div class="flex justify-between items-center p-4 bg-white rounded-lg border border-gray-200 hover:border-accent/30 hover:shadow-sm transition-all duration-200">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                                    {{ substr($bid->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-800">{{ $bid->user->name }}</p>
                                                    <p class="text-sm text-gray-500">{{ $bid->created_at->format('d/m/Y H:i') }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-bold text-lg text-accent">{{ $bid->formatted_bid_amount }}</p>
                                                @if($loop->first)
                                                    <span class="text-xs bg-accent/10 text-accent px-3 py-1 rounded-full font-medium">Tertinggi</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Bid Information -->
        <div class="space-y-6">
            <!-- Current Bid Status -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 bg-primary text-white">
                    <h3 class="text-lg font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Status Lelang
                    </h3>
                </div>
                
                <div class="p-6 space-y-4">
                    <!-- Current Bid Display -->
                    <div class="current-bid-display">
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-1">Penawaran Tertinggi</p>
                            <p class="text-3xl font-bold text-green-600">{{ $auction->formatted_current_bid }}</p>
                            @if($auction->bids->count() > 0)
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $auction->bids->count() }} 
                                    {{ $auction->bids->count() == 1 ? 'penawaran' : 'penawaran' }}
                                </p>
                            @else
                                <p class="text-sm text-gray-500 mt-1">Belum ada penawaran</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Time Remaining -->
                    @if($auction->isActive())
                        <div class="text-center bg-orange-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-2 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Waktu Tersisa
                            </p>
                            <div x-data="countdown('{{ $auction->end_time }}')" x-init="init()">
                                <p x-text="timeString" class="text-xl font-bold text-orange-600"></p>
                            </div>
                        </div>
                    @elseif($auction->hasEnded())
                        <div class="text-center bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-2 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Status
                            </p>
                            <p class="text-lg font-bold text-gray-600">Lelang Berakhir</p>
                            @if($auction->winner_id)
                                <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                    <p class="text-sm text-blue-700 font-medium flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Pemenang: {{ $auction->winner->name }}
                                    </p>
                                    <p class="text-sm text-gray-600 flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        Harga Final: <span class="font-bold text-accent">{{ $auction->formatted_final_price }}</span>
                                    </p>
                                </div>
                            @else
                                <p class="text-sm text-gray-600">Tidak ada pemenang</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Bid Form -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @auth
                    @if($auction->isActive() && Auth::user()->role === 'user')
                        <div class="bg-primary p-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                Ajukan Penawaran Anda
                            </h3>
                            <p class="text-white text-sm mt-1 opacity-90">Masukkan jumlah penawaran untuk ikut serta dalam lelang</p>
                        </div>
                        
                        <div class="p-6 bg-neutral/30">
                            <!-- Current Bid Summary -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="bg-primary text-white p-4 rounded-lg shadow-sm">
                                    <div class="flex items-center text-white/70 mb-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        <span class="text-xs font-medium">Harga Saat Ini</span>
                                    </div>
                                    <p class="text-xl font-bold">Rp {{ number_format($auction->current_bid, 0, ',', '.') }}</p>
                                </div>
                                
                                <div class="bg-accent text-white p-4 rounded-lg shadow-sm">
                                    <div class="flex items-center text-white/70 mb-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                        </svg>
                                        <span class="text-xs font-medium">Minimum Penawaran</span>
                                    </div>
                                    <p class="text-xl font-bold">Rp {{ number_format($auction->current_bid + 1000, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <form action="{{ route('auctions.bid', $auction) }}" method="POST" class="space-y-5">
                                @csrf
                                
                                <!-- Bid Input Section -->
                                <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                                    <!-- Info Box -->
                                    <div class="mb-6 p-4 bg-neutral rounded-lg border-l-4 border-accent">
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-accent mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm text-charcoal font-semibold mb-3">
                                                    Minimum penawaran adalah <span class="font-bold text-accent">Rp {{ number_format($auction->current_bid + 1000, 0, ',', '.') }}</span>
                                                </p>
                                                <ul class="text-xs text-gray-600 space-y-1.5">
                                                    <li>• Penawaran harus lebih tinggi minimal Rp 1.000 dari harga saat ini</li>
                                                    <li>• Format akan otomatis disesuaikan (contoh: 1.250.000)</li>
                                                    <li>• Penawaran yang telah diajukan tidak dapat dibatalkan</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Input Field Section -->
                                    <div class="space-y-6">
                                        <div>
                                            <label for="bid_amount_display" class="block text-sm font-semibold text-gray-800 mb-3">
                                                <svg class="w-4 h-4 inline mr-2 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                                Masukkan Jumlah Penawaran
                                            </label>
                                            <div class="relative">
                                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium text-base pointer-events-none z-10">
                                                    Rp
                                                </div>
                                                <input type="text" 
                                                       name="bid_amount_display" 
                                                       id="bid_amount_display"
                                                       placeholder="{{ number_format($auction->current_bid + 1000, 0, ',', '.') }}"
                                                       class="w-full pl-12 pr-4 py-4 text-lg font-semibold border-2 rounded-xl focus:border-accent focus:ring-4 focus:ring-accent/20 transition-all duration-200 {{ $errors->has('bid_amount') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}"
                                                       autocomplete="off">
                                                <input type="hidden" 
                                                       name="bid_amount" 
                                                       id="bid_amount"
                                                       min="{{ $auction->current_bid + 1000 }}"
                                                       step="1000">
                                            </div>
                                        </div>
                                        
                                        <!-- Quick Bid Buttons Section -->
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-800 mb-3">
                                                <svg class="w-4 h-4 inline mr-2 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                                Quick Bid Options
                                            </label>
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                                <button type="button" class="bg-accent hover:bg-accent/80 text-white px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105 quick-bid-btn" data-amount="{{ $auction->current_bid + 50000 }}">
                                                    +50rb
                                                </button>
                                                <button type="button" class="bg-accent hover:bg-accent/80 text-white px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105 quick-bid-btn" data-amount="{{ $auction->current_bid + 100000 }}">
                                                    +100rb
                                                </button>
                                                <button type="button" class="bg-accent hover:bg-accent/80 text-white px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105 quick-bid-btn" data-amount="{{ $auction->current_bid + 250000 }}">
                                                    +250rb
                                                </button>
                                                <button type="button" class="bg-accent hover:bg-accent/80 text-white px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105 quick-bid-btn" data-amount="{{ $auction->current_bid + 500000 }}">
                                                    +500rb
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @error('bid_amount')
                                        <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                            <p class="text-red-700 text-sm flex items-center">
                                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        </div>
                                    @enderror

                                    <!-- Submit Button -->
                                    <div class="mt-6 pt-4 border-t border-gray-200">
                                        <button type="submit" class="w-full bg-accent hover:bg-accent/80 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center space-x-3" id="bidButton">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                            <span class="text-lg">Ajukan Penawaran</span>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                        
                                        <!-- Terms Note -->
                                        <p class="text-xs text-gray-500 text-center mt-3">
                                            Dengan mengajukan penawaran, Anda menyetujui 
                                            <a href="#" class="text-accent hover:underline">syarat dan ketentuan</a> lelang
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @elseif($auction->isActive() && Auth::user()->role !== 'user')
                        <div class="p-6">
                            <div class="text-center p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <svg class="mx-auto h-8 w-8 text-yellow-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <p class="text-yellow-800 text-sm font-medium flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    Hanya pengguna terdaftar yang dapat mengajukan penawaran
                                </p>
                            </div>
                        </div>
                    @endif
                @else
                    @if($auction->isActive())
                        <div class="p-4 bg-primary text-white">
                            <h3 class="text-lg font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Login Diperlukan
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="text-center space-y-4">
                                <p class="text-gray-600 text-sm">Login terlebih dahulu untuk mengajukan penawaran</p>
                                <div class="space-y-3">
                                    <a href="{{ route('login') }}" class="btn-primary w-full text-center flex items-center justify-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span>Login</span>
                                    </a>
                                    <a href="{{ route('register') }}" class="btn-secondary w-full text-center flex items-center justify-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                        </svg>
                                        <span>Daftar</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- User's Bid History (if logged in) -->
            @auth
                @if($userBids && $userBids->count() > 0)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-4 bg-primary text-white">
                            <h3 class="text-lg font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Penawaran Anda
                                <span class="ml-2 px-2 py-1 bg-white/20 text-xs rounded-full">{{ $userBids->count() }}</span>
                            </h3>
                        </div>
                        <div class="max-h-64 overflow-y-auto p-2">
                            @foreach($userBids as $bid)
                                <div class="p-4 mb-3 rounded-lg border {{ $loop->first ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }} {{ $loop->last ? 'mb-0' : '' }}">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-semibold text-lg {{ $loop->first ? 'text-green-700' : 'text-gray-700' }}">
                                            {{ $bid->formatted_bid_amount }}
                                        </span>
                                        <span class="text-sm {{ $loop->first ? 'text-green-600' : 'text-gray-500' }}">
                                            {{ $bid->created_at->format('d/m H:i') }}
                                        </span>
                                    </div>
                                    @if($loop->first)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-xs text-green-600 font-medium">Penawaran Tertinggi Anda</span>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-500">Penawaran sebelumnya</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>

<!-- Auto-formatting Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing auto-formatting...');
    
    // Auto-format bid amount input
    const bidAmountDisplay = document.getElementById('bid_amount_display');
    const bidAmountHidden = document.getElementById('bid_amount');
    
    if (bidAmountDisplay && bidAmountHidden) {
        console.log('Auto-formatting elements found successfully!');
        
        // Real-time number formatting for Indonesian currency
        bidAmountDisplay.addEventListener('input', function(e) {
            console.log('Input detected:', e.target.value);
            
            // Store cursor position
            let cursorPos = e.target.selectionStart;
            let oldValue = e.target.value;
            let oldLen = oldValue.length;
            
            // Remove all non-digit characters
            let numbers = e.target.value.replace(/\D/g, '');
            
            // Format the number with thousand separators
            let formatted = '';
            if (numbers) {
                let num = parseInt(numbers);
                if (!isNaN(num) && num > 0) {
                    formatted = num.toLocaleString('id-ID');
                }
            }
            
            console.log('Numbers extracted:', numbers);
            console.log('Formatted to:', formatted);
            
            // Update the input value
            e.target.value = formatted;
            
            // Calculate new cursor position
            let newLen = formatted.length;
            let lengthDiff = newLen - oldLen;
            
            // Adjust cursor position
            if (lengthDiff > 0) {
                cursorPos += lengthDiff;
            } else if (lengthDiff < 0) {
                cursorPos = Math.max(0, cursorPos + lengthDiff);
            }
            
            cursorPos = Math.min(cursorPos, formatted.length);
            
            // Set cursor position
            requestAnimationFrame(() => {
                e.target.setSelectionRange(cursorPos, cursorPos);
            });
            
            // Update hidden input
            let numericValue = numbers ? parseInt(numbers) : 0;
            bidAmountHidden.value = numericValue;
            
            console.log('Hidden value set to:', numericValue);
        });

        // Handle keydown for number-only input
        bidAmountDisplay.addEventListener('keydown', function(e) {
            console.log('Key pressed:', e.keyCode);
            
            // Allow: backspace, delete, tab, escape, enter, arrows
            if ([8, 9, 27, 13, 46, 37, 38, 39, 40].indexOf(e.keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (e.ctrlKey && [65, 67, 86, 88].indexOf(e.keyCode) !== -1)) {
                return;
            }
            // Ensure that it is a number
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
                console.log('Non-numeric key blocked');
            }
        });

        // Handle paste
        bidAmountDisplay.addEventListener('paste', function(e) {
            e.preventDefault();
            let paste = (e.clipboardData || window.clipboardData).getData('text');
            let numbers = paste.replace(/\D/g, '');
            
            console.log('Paste detected:', paste, 'Numbers:', numbers);
            
            if (numbers) {
                let numericValue = parseInt(numbers);
                let formattedValue = numericValue.toLocaleString('id-ID');
                e.target.value = formattedValue;
                bidAmountHidden.value = numericValue;
                
                console.log('Paste formatted to:', formattedValue);
            }
        });
        
        // Test formatting on page load
        console.log('Testing Indonesian formatting:');
        console.log('123456 ->', (123456).toLocaleString('id-ID'));
        console.log('1000000 ->', (1000000).toLocaleString('id-ID'));
        
    } else {
        console.log('Auto-formatting elements not found!');
        console.log('bidAmountDisplay:', bidAmountDisplay);
        console.log('bidAmountHidden:', bidAmountHidden);
    }

    // Quick Bid Buttons Handler
    const quickBidButtons = document.querySelectorAll('.quick-bid-btn');
    quickBidButtons.forEach(button => {
        button.addEventListener('click', function() {
            const amount = parseInt(this.dataset.amount);
            
            console.log('Quick bid clicked, amount:', amount);
            
            // Update display field
            if (bidAmountDisplay) {
                bidAmountDisplay.value = amount.toLocaleString('id-ID');
            }
            
            // Update hidden field
            if (bidAmountHidden) {
                bidAmountHidden.value = amount;
            }
            
            console.log('Quick bid set to:', amount);
            console.log('Display value:', bidAmountDisplay.value);
            console.log('Hidden value:', bidAmountHidden.value);
        });
    });
});
</script>

<!-- Countdown Script -->
<script>
function countdown(endTime) {
    return {
        timeString: 'Loading...',
        init() {
            this.updateCountdown();
            setInterval(() => {
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
                    this.timeString = `${days}h ${hours}j ${minutes}m ${seconds}d`;
                } else if (hours > 0) {
                    this.timeString = `${hours}j ${minutes}m ${seconds}d`;
                } else {
                    this.timeString = `${minutes}m ${seconds}d`;
                }
            } else {
                this.timeString = 'Berakhir';
                setTimeout(() => location.reload(), 2000);
            }
        }
    };
}

// Notification function  
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 5000);
}
</script>
@endsection
