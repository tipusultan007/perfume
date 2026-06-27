<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NYTaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Wipe out old tax rates since we are focusing strictly on NY Compliance
        \App\Models\TaxRate::truncate();

        // 2. Base NY State Rate Fallback (For any NY zip we miss)
        \App\Models\TaxRate::create([
            'name' => 'NY State Base Tax',
            'rate' => 4.00,
            'state_code' => 'NY',
            'zip_code' => null,
            'is_shipping_taxable' => true,
            'is_active' => true,
        ]);

        // 3. Generate the 1,700+ NY Zip Codes programmatically
        $nyZipRanges = [];

        for ($zip = 10001; $zip <= 14925; $zip++) {
            $zipStr = str_pad($zip, 5, '0', STR_PAD_LEFT);
            $prefix3 = substr($zipStr, 0, 3);
            
            $rate = 8.00; // Default upstate NY rate approx
            $name = 'Upstate NY Local Tax';

            // NYC (Manhattan, Bronx, Staten Island, Brooklyn, Queens)
            if (in_array($prefix3, ['100', '101', '102', '103', '104', '111', '112', '113', '114', '116'])) {
                $rate = 8.875;
                $name = 'NYC Local Tax';
            } 
            // Long Island (Nassau / Suffolk)
            elseif (in_array($prefix3, ['110', '115', '117', '118', '119'])) {
                $rate = 8.625;
                $name = 'Long Island Local Tax';
            }
            // Westchester / Rockland
            elseif (in_array($prefix3, ['105', '106', '107', '108', '109'])) {
                $rate = 8.375;
                $name = 'Westchester/Rockland Local Tax';
            }

            $nyZipRanges[] = [
                'name' => $name,
                'rate' => $rate,
                'state_code' => 'NY',
                'zip_code' => $zipStr,
                'is_shipping_taxable' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Mass insert in chunks for performance
        $chunks = array_chunk($nyZipRanges, 500);
        foreach ($chunks as $chunk) {
            \Illuminate\Support\Facades\DB::table('tax_rates')->insert($chunk);
        }
    }
}
