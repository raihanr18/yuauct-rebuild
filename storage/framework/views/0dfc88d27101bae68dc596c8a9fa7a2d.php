<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-primary">
        <div class="min-h-screen flex flex-col justify-center items-center py-12">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-gradient-to-br from-primary via-slate-800 to-slate-900"></div>
            
            <!-- Content -->
            <div class="relative z-10 w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <a href="/" class="inline-block p-2 rounded-lg" style="background-color: rgba(255, 255, 255, 0.15);">
                        <?php if (isset($component)) { $__componentOriginal987d96ec78ed1cf75b349e2e5981978f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal987d96ec78ed1cf75b349e2e5981978f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.logo','data' => ['variant' => 'nobg','size' => 'h-16','showText' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'nobg','size' => 'h-16','showText' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal987d96ec78ed1cf75b349e2e5981978f)): ?>
<?php $attributes = $__attributesOriginal987d96ec78ed1cf75b349e2e5981978f; ?>
<?php unset($__attributesOriginal987d96ec78ed1cf75b349e2e5981978f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal987d96ec78ed1cf75b349e2e5981978f)): ?>
<?php $component = $__componentOriginal987d96ec78ed1cf75b349e2e5981978f; ?>
<?php unset($__componentOriginal987d96ec78ed1cf75b349e2e5981978f); ?>
<?php endif; ?>
                    </a>
                    <h1 class="text-3xl font-bold text-white mt-4 drop-shadow-lg">YuAUCT</h1>
                    <p class="text-gray-200 text-sm mt-2 font-medium">Platform Lelang Online Terpercaya</p>
                </div>

                <!-- Auth Card -->
                <div class="bg-white shadow-2xl rounded-2xl px-8 py-8 border border-gray-200">
                    <?php echo e($slot); ?>

                </div>

                <!-- Footer Link -->
                <div class="text-center mt-6">
                    <a href="<?php echo e(route('home')); ?>" class="text-gray-200 hover:text-accent transition-colors text-sm font-medium">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
<?php /**PATH D:\Documents\Lab\yuauct-rebuild\resources\views/layouts/guest.blade.php ENDPATH**/ ?>