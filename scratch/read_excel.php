<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Maatwebsite\Excel\Facades\Excel;

$path = storage_path('app/public/products.xlsx');
if (!file_exists($path)) {
    echo "File not found: $path\n";
    exit;
}

// Read the rows using SimpleExcel or loading it
$data = Excel::toArray(new stdClass(), $path);

if (empty($data)) {
    echo "No sheets found in Excel file.\n";
    exit;
}

$sheet = $data[0];
echo "Total Rows: " . count($sheet) . "\n";
echo "Headers:\n";
print_r($sheet[0] ?? []);

echo "\nFirst 5 rows of data:\n";
for ($i = 1; $i <= min(5, count($sheet) - 1); $i++) {
    print_r($sheet[$i] ?? []);
}
