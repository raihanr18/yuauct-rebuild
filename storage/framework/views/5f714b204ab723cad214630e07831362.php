<?php if($variant === 'nobg'): ?>
    <img src="<?php echo e(asset('images/logo-nobg.png')); ?>" alt="<?php echo e(config('app.name')); ?>" class="<?php echo e($size); ?>">
<?php else: ?>
    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="<?php echo e(config('app.name')); ?>" class="<?php echo e($size); ?>">
<?php endif; ?>

<?php if($showText): ?>
    <span class="ml-2 text-xl font-bold text-white"><?php echo e(config('app.name')); ?></span>
<?php endif; ?><?php /**PATH D:\Documents\Lab\yuauct-rebuild\resources\views/components/logo.blade.php ENDPATH**/ ?>