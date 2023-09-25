<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        User::insert([
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => bcrypt(11111111),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alexander Pierce',
                'email' => 'alexander@example.com',
                'password' => bcrypt(11111111),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $faker = \Faker\Factory::create();

        for ($i=0; $i < 10; $i++) { 
            $data[] = [
                'name' => $faker->name(),
                'email' => $faker->unique()->email(),
                'password' => bcrypt(1111111),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        User::insert($data);
    }
}
