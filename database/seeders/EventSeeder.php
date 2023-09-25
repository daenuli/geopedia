<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use App\Models\Type;
use App\Models\City;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::truncate();
        $faker = \Faker\Factory::create();
        // $faker = Faker\Factory::create();
        // for($i=1; $i<10; $i++) {
            
        // }

        $user = User::pluck('id');
        $type = Type::pluck('id');
        $city = City::pluck('id');


        foreach ($user as $key => $value) {
            $data[] = [
                'user_id' => $value,
                'type_id' => $faker->randomElement($type),
                'name' => $faker->sentence(),
                'city_id' => $faker->randomElement($city),
                'image' => null,
                'start_date' => now()->addDays($key),
                'price' => rand(1,9) * 100000,
                'description' => $faker->paragraph(),
                'created_at' => now()->addDays($key),
                'updated_at' => now()->addDays($key),
            ];
        }
        Event::insert($data);
    }
}
