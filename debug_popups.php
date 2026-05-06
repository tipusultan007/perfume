<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "--- ALL POPUPS ---\n";
$popups = \App\Models\Popup::all();
foreach ($popups as $p) {
    echo 'ID: '.$p->id.' | ';
    echo 'Active: '.($p->is_active ? 'YES' : 'NO').' | ';
    echo 'Start: '.($p->start_date ?: 'NULL').' | ';
    echo 'End: '.($p->end_date ?: 'NULL').' | ';
    echo 'Created: '.$p->created_at.' | ';
    echo 'Title: '.$p->title."\n";
}

echo "\n--- CURRENT APP TIME ---\n";
echo now().' ('.config('app.timezone').")\n";

echo "\n--- QUERY RESULTS (Same as AppServiceProvider) ---\n";
$activeOnes = \App\Models\Popup::where('is_active', true)
    ->where(function ($query) {
        $query->whereNull('start_date')
            ->orWhere('start_date', '<=', now());
    })
    ->where(function ($query) {
        $query->whereNull('end_date')
            ->orWhere('end_date', '>=', now());
    })
    ->orderBy('created_at', 'desc')
    ->get();

foreach ($activeOnes as $p) {
    echo 'MATCHED: ID: '.$p->id.' - Title: '.$p->title."\n";
}

if ($activeOnes->isEmpty()) {
    echo "NO POPUPS MATCHED LOGIC\n";
}
