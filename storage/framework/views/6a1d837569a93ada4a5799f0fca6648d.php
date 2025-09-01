

<?php $__env->startSection('title', 'Beranda'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<div class="relative bg-primary">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                Selamat Datang di <span class="text-accent">YuAUCT</span>
            </h1>
            <p class="text-xl text-gray-300 mb-8 max-w-3xl mx-auto">
                Platform lelang online terpercaya untuk barang antik dan koleksi langka. 
                Temukan item unik dengan harga terbaik!
            </p>
            <div class="space-x-4">
                <a href="<?php echo e(route('auctions.index')); ?>" class="btn-accent text-lg px-8 py-3">
                    Lihat Lelang
                </a>
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('register')); ?>" class="btn-secondary text-lg px-8 py-3">
                        Daftar Sekarang
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Featured Auctions -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-primary mb-4">Lelang Unggulan</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
            Temukan koleksi barang antik dan item langka yang sedang dilelang dengan harga menarik
        </p>
    </div>

    <?php if($featuredAuctions->count() > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php $__currentLoopData = $featuredAuctions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="auction-card">
                    <div class="relative">
                        <img src="<?php echo e($auction->item->image_url); ?>" alt="<?php echo e($auction->item->name); ?>" 
                             class="w-full h-48 object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="status-badge status-<?php echo e($auction->status); ?>">
                                <?php echo e(ucfirst($auction->status)); ?>

                            </span>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-semibold text-primary"><?php echo e($auction->item->name); ?></h3>
                            <span class="text-xs text-gray-500"><?php echo e($auction->item->category->name); ?></span>
                        </div>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            <?php echo e(Str::limit($auction->item->description, 100)); ?>

                        </p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Harga Saat Ini:</span>
                                <span class="bid-amount"><?php echo e($auction->formatted_current_bid); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Berakhir:</span>
                                <span class="countdown-timer" 
                                      x-data="countdown('<?php echo e($auction->end_time->toISOString()); ?>')"
                                      x-text="timeString">
                                    Loading...
                                </span>
                            </div>
                        </div>
                        
                        <a href="<?php echo e(route('auctions.show', $auction)); ?>" 
                           class="btn-primary w-full text-center">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="<?php echo e(route('auctions.index')); ?>" class="btn-accent text-lg px-8 py-3">
                Lihat Semua Lelang
            </a>
        </div>
    <?php else: ?>
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">Belum ada lelang yang tersedia saat ini.</p>
            <p class="text-gray-400 text-sm mt-2">Pantau terus untuk mendapatkan lelang terbaru!</p>
        </div>
    <?php endif; ?>
</div>

<!-- Categories Section -->
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-primary mb-4">Kategori Populer</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Jelajahi berbagai kategori barang antik dan koleksi unik
            </p>
        </div>

        <?php if($categories->count() > 0): ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('auctions.index', ['category' => $category->id])); ?>" 
                       class="text-center p-6 rounded-lg border border-gray-200 hover:border-accent hover:shadow-md transition-all duration-200">
                        <h3 class="font-semibold text-primary mb-2"><?php echo e($category->name); ?></h3>
                        <span class="text-sm text-gray-500"><?php echo e($category->items_count); ?> item</span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Features Section -->
<div class="bg-neutral py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-primary mb-4">Mengapa Memilih YuAUCT?</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-accent rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-primary mb-2">Aman & Terpercaya</h3>
                <p class="text-gray-600">Sistem keamanan berlapis untuk melindungi transaksi Anda</p>
            </div>

            <div class="text-center">
                <div class="bg-accent rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-primary mb-2">Real-time</h3>
                <p class="text-gray-600">Notifikasi dan update harga secara langsung</p>
            </div>

            <div class="text-center">
                <div class="bg-accent rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-primary mb-2">Koleksi Eksklusif</h3>
                <p class="text-gray-600">Barang antik dan langka yang telah diverifikasi</p>
            </div>
        </div>
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
                const seconds = Math.floor((difference % (1000 * 60)) / 1000);
                
                if (days > 0) {
                    this.timeString = `${days}h ${hours}j ${minutes}m`;
                } else if (hours > 0) {
                    this.timeString = `${hours}j ${minutes}m ${seconds}d`;
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\yuauct-laravel\resources\views/home.blade.php ENDPATH**/ ?>