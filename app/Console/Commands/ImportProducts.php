<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from an Excel file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = $this->argument('path');

        if (!file_exists($path)) {
            $this->error("File not found at: {$path}");
            return 1;
        }

        $this->info("Starting import from {$path}...");

        try {
            Excel::import(new ProductsImport, $path);
            $this->info("Import completed successfully!");
        } catch (\Exception $e) {
            $this->error("Import failed: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
