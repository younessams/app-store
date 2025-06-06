<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Size;

class SizeSeeder extends Seeder
{
    public function run()
    {
        $sizes = ['38', '39', '40', '41', '42', '43', '44', '45'];

        foreach ($sizes as $size) {
            Size::firstOrCreate(['name' => $size]);
        }
    }
}
