<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxAndShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            'AL' => 4.00, 'AK' => 0.00, 'AZ' => 5.60, 'AR' => 6.50, 'CA' => 7.25,
            'CO' => 2.90, 'CT' => 6.35, 'DE' => 0.00, 'FL' => 6.00, 'GA' => 4.00,
            'HI' => 4.00, 'ID' => 6.00, 'IL' => 6.25, 'IN' => 7.00, 'IA' => 6.00,
            'KS' => 6.50, 'KY' => 6.00, 'LA' => 4.45, 'ME' => 5.50, 'MD' => 6.00,
            'MA' => 6.25, 'MI' => 6.00, 'MN' => 6.875, 'MS' => 7.00, 'MO' => 4.225,
            'MT' => 0.00, 'NE' => 5.50, 'NV' => 6.85, 'NH' => 0.00, 'NJ' => 6.625,
            'NM' => 5.125, 'NY' => 4.00, 'NC' => 4.75, 'ND' => 5.00, 'OH' => 5.75,
            'OK' => 4.50, 'OR' => 0.00, 'PA' => 6.00, 'RI' => 7.00, 'SC' => 6.00,
            'SD' => 4.50, 'TN' => 7.00, 'TX' => 6.25, 'UT' => 4.85, 'VT' => 6.00,
            'VA' => 4.30, 'WA' => 6.50, 'WV' => 6.00, 'WI' => 5.00, 'WY' => 4.00
        ];

        // Global fallback shipping
        \App\Models\ShippingRate::updateOrCreate(
            ['name' => 'Standard US Shipping', 'state_code' => null, 'zip_code' => null],
            ['cost' => 10.00, 'is_active' => true]
        );

        foreach ($states as $code => $tax) {
            \App\Models\TaxRate::updateOrCreate(
                ['state_code' => $code, 'zip_code' => null],
                [
                    'name' => "{$code} State Tax",
                    'rate' => $tax,
                    'priority' => 1,
                    'is_active' => true,
                    'is_shipping_taxable' => true
                ]
            );

            // Shipping logic based on distance from New York
            $shippingCost = 10.00; // Default
            
            $zone1 = ['NY', 'NJ', 'CT', 'PA']; // Very close
            $zone2 = ['MA', 'RI', 'VT', 'NH', 'ME', 'MD', 'DE', 'VA', 'DC']; // East Coast
            $zone3 = ['CA', 'OR', 'WA', 'NV', 'AZ', 'ID', 'UT', 'MT', 'WY', 'NM', 'CO']; // West Coast / Rockies
            $zone4 = ['AK', 'HI']; // Non-contiguous
            
            if (in_array($code, $zone1)) {
                $shippingCost = 5.00;
            } elseif (in_array($code, $zone2)) {
                $shippingCost = 8.00;
            } elseif (in_array($code, $zone3)) {
                $shippingCost = 15.00;
            } elseif (in_array($code, $zone4)) {
                $shippingCost = 25.00;
            } else {
                $shippingCost = 12.00; // Midwest / South
            }

            \App\Models\ShippingRate::updateOrCreate(
                ['state_code' => $code, 'zip_code' => null],
                ['name' => "Standard Shipping ({$code})", 'cost' => $shippingCost, 'is_active' => true]
            );
        }
    }
}
