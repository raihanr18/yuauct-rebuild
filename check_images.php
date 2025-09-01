<?php

require_once 'bootstrap/app.php';

$app = Illuminate\Foundation\Application::configure(basePath: __DIR__)
    ->withRouting(
        web: __DIR__.'/routes/web.php',
        commands: __DIR__.'/routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Illuminate\Foundation\Configuration\Middleware $middleware) {
        //
    })
    ->withExceptions(function (Illuminate\Foundation\Configuration\Exceptions $exceptions) {
        //
    })->create();

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing image paths:\n";
foreach(App\Models\Item::all() as $item) {
    echo "Item: " . $item->name . " -> Image: " . $item->image . "\n";
}
