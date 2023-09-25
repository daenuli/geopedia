<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type; 

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Type::truncate();
        Type::insert([
            ['name' => 'Music'],
            ['name' => 'Comedy'],
            ['name' => 'Magic'],
            ['name' => 'Circus'],
            ['name' => 'Opera'],
            ['name' => 'Bisnis'],
            ['name' => 'Game'],
            ['name' => 'Investasi'],
        ]);
    }
}
