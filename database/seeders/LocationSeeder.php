<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $url = 'https://raw.githubusercontent.com/kelvins/US-Cities-Database/main/csv/us_cities.csv';
        $file = fopen($url, 'r');
        
        if (!$file) {
            $this->command->error("Could not open CSV file.");
            return;
        }

        $header = fgetcsv($file);
        
        $states = [];
        $cities = [];
        $uniqueCities = [];
        
        $this->command->info("Seeding states and cities...");

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        City::truncate();
        State::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        while (($row = fgetcsv($file)) !== false) {
            $stateCode = $row[1];
            $stateName = $row[2];
            $cityName = $row[3];
            
            if (!isset($states[$stateCode])) {
                $state = State::create([
                    'state_code' => $stateCode,
                    'name' => $stateName
                ]);
                $states[$stateCode] = $state->id;
            }
            
            $cityKey = $states[$stateCode] . '_' . strtolower($cityName);
            
            if (!isset($uniqueCities[$cityKey])) {
                $uniqueCities[$cityKey] = true;
                
                $cities[] = [
                    'state_id' => $states[$stateCode],
                    'name' => $cityName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            if (count($cities) >= 1000) {
                City::insert($cities);
                $cities = [];
            }
        }
        
        if (count($cities) > 0) {
            City::insert($cities);
        }
        
        fclose($file);
        
        $this->command->info("Seeding completed!");
    }
}
