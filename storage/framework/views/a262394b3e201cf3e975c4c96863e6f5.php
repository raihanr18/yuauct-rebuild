<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['variant' => 'default', 'size' => 'h-8', 'showText' => true]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['variant' => 'default', 'size' => 'h-8', 'showText' => true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$logoSrc = match($variant) {
    'nobg' => asset('images/logo-nobg.png'),
    'transparent' => asset('images/logo-nobg.png'),
    default => asset('images/logo.png'),
};
?>

<div class="flex items-center">
    <img class="<?php echo e($size); ?> w-auto" src="<?php echo e($logoSrc); ?>" alt="YuAUCT">
    <?php if($showText): ?>
        <span class="ml-2 text-xl font-bold">YuAUCT</span>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\yuauct-laravel\resources\views/components/logo.blade.php ENDPATH**/ ?>