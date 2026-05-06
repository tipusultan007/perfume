<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$ids = \App\Models\Popup::where('is_active', true)->pluck('id')->toArray();
echo implode(',', $ids)."\n";
