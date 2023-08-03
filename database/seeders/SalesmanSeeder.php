<?php

namespace Database\Seeders;

use App\Models\Salesman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesmanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Salesman::factory()
            ->count(20)
            ->create();
    }
}
