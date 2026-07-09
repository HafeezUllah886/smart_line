<?php

namespace Database\Seeders;

use App\Models\products;
use Illuminate\Database\Seeder;

class productsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Petrol', 'price' => 290, 'unit' => 'Liter'],
            ['name' => 'Diesel', 'price' => 285, 'unit' => 'Liter'],
        ];
        products::insert($data);
    }
}
