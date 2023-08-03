<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conversionFromUSD = [
            'COP' => 4107,
            'CLP' => 855,
            'ARS' => 278,
            'PEN' => 3,
            'USD' => 1,
            'MXN' => 17,
            'UYU' => 37,
            'PYG' => 7273,
            'BOP' => 7,
        ];

        $products = Product::all();
        foreach ($products as $product) {
            $priceInUSD = random_int(2, 150);
            $branches = Branch::inRandomOrder()->limit(2)->get();
            foreach ($branches as $branch) {
                DB::table('branch_product')->insert([
                    'product_id' => $product->id,
                    'branch_id' => $branch->id,
                    'stock' => random_int(2, 10),
                    'price' => $priceInUSD * $conversionFromUSD[$branch->money_code],
                    'created_at' => date('Y-m-d H-i-s'),
                    'updated_at' => date('Y-m-d H-i-s'),
                ]);
            }
        }
    }
}
