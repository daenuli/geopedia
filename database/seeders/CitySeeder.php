<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::truncate();

        $faker = \Faker\Factory::create();
        for ($i=0; $i < 20; $i++) { 
            $data[] = [
                'name' => $faker->unique()->city()
            ];
        }
        City::insert($data);
    }
}
