<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Staff\ItemController as StaffItemController;
use App\Http\Controllers\Staff\AuctionController as StaffAuctionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/auctions', [HomeController::class, 'auctions'])->name('auctions.index');
Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');
Route::get('/auctions/{auction}/data', [AuctionController::class, 'currentData'])->name('auctions.data');

// Authenticated user routes
Route::middleware(['auth', \App\Http\Middleware\TrackLastLogin::class])->group(function () {
    // Bidding (only for users)
    Route::post('/auctions/{auction}/bid', [AuctionController::class, 'bid'])
        ->middleware('role:user')
        ->name('auctions.bid');
    
    // Dashboard
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        if ($user->isStaff()) {
            return redirect()->route('staff.dashboard');
        }
        
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Staff & Admin routes
Route::middleware(['auth', 'role:staff,admin', \App\Http\Middleware\TrackLastLogin::class])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');
    
    // Item management
    Route::resource('items', StaffItemController::class);
    
    // Auction management
    Route::resource('auctions', StaffAuctionController::class);
    Route::patch('auctions/{auction}/start', [StaffAuctionController::class, 'start'])->name('auctions.start');
    Route::patch('auctions/{auction}/close', [StaffAuctionController::class, 'close'])->name('auctions.close');
    Route::patch('auctions/{auction}/cancel', [StaffAuctionController::class, 'cancel'])->name('auctions.cancel');
});

// Admin only routes
Route::middleware(['auth', 'role:admin', \App\Http\Middleware\TrackLastLogin::class])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User management with additional actions
    Route::resource('users', UserController::class);
    Route::post('users/{user}/suspend', [UserController::class, 'suspend'])->name('users.suspend');
    Route::post('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
    
    // System management routes (future expansion)
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');
    
    Route::get('/logs', function () {
        return view('admin.logs');
    })->name('logs');
});

require __DIR__.'/auth.php';
