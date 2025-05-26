<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    public function run()
    {
        $colors = [
            ['name' => 'Red', 'class' => 'bg-red-500'],
            ['name' => 'Blue', 'class' => 'bg-blue-500'],
            ['name' => 'Green', 'class' => 'bg-green-500'],
            ['name' => 'Yellow', 'class' => 'bg-yellow-500'],
            ['name' => 'Purple', 'class' => 'bg-purple-500'],
            ['name' => 'Pink', 'class' => 'bg-pink-500'],
            ['name' => 'Orange', 'class' => 'bg-orange-500'],
            ['name' => 'Gray', 'class' => 'bg-gray-500'],
            ['name' => 'Black', 'class' => 'bg-black'],
            ['name' => 'White', 'class' => 'bg-white border border-gray-300'],
        ];

        foreach ($colors as $color) {
            Color::firstOrCreate([
                'name'  => $color['name'],
                'class' => $color['class'],
            ]);
        }
    }
}
