<?php

namespace Database\Seeders;

use App\Models\accounts;
use Illuminate\Database\Seeder;

class accountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        accounts::create(
            [
                'title' => 'Cash Account',
                'type' => 'Business',
                'category' => 'Cash',
            ]
        );

        accounts::create(
            [
                'title' => 'Walking Customer',
                'type' => 'Customer',

            ]
        );

        accounts::create(
            [
                'title' => 'Walk-In Supplier',
                'type' => 'Supplier',
            ]
        );
        accounts::create(
            [
                'title' => 'Test Check Post',
                'type' => 'Check Post',
            ]
        );
    }
}
