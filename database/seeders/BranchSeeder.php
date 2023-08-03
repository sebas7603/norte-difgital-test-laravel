<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('branches')->insert([
            [
                'id' => 1,
                'country' => 'CO',
                'money_code' => 'COP',
                'money_symbol' => '$',
            ],
            [
                'id' => 2,
                'country' => 'CL',
                'money_code' => 'CLP',
                'money_symbol' => '$',
            ],
            [
                'id' => 3,
                'country' => 'AR',
                'money_code' => 'ARS',
                'money_symbol' => '$',
            ],
            [
                'id' => 4,
                'country' => 'PE',
                'money_code' => 'PEN',
                'money_symbol' => 'S/',
            ],
            [
                'id' => 5,
                'country' => 'EC',
                'money_code' => 'USD',
                'money_symbol' => '$',
            ],
            [
                'id' => 6,
                'country' => 'MX',
                'money_code' => 'MXN',
                'money_symbol' => '$',
            ],
            [
                'id' => 7,
                'country' => 'PA',
                'money_code' => 'USD',
                'money_symbol' => '$',
            ],
            [
                'id' => 8,
                'country' => 'UY',
                'money_code' => 'UYU',
                'money_symbol' => '$',
            ],
            [
                'id' => 9,
                'country' => 'PY',
                'money_code' => 'PYG',
                'money_symbol' => '₲',
            ],
            [
                'id' => 10,
                'country' => 'BO',
                'money_code' => 'BOP',
                'money_symbol' => '$',
            ],
        ]);
    }
}
