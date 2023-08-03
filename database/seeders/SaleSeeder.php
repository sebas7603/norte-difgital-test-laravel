<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Salesman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();
        foreach ($clients as $client) {
            $sales = random_int(1, 3);
            for ($i=0; $i < $sales; $i++) {
                $total = 0;
                $branch = Branch::inRandomOrder()->first();
                $products = $branch->products()->inRandomOrder()->limit(random_int(1, 3))->get();

                $sale = Sale::create([
                    'salesman_id' => Salesman::inRandomOrder()->first()->id,
                    'client_id' => $client->id,
                    'branch_id' => $branch->id,
                ]);

                foreach ($products as $product) {
                    $quantity = random_int(1, $product->pivot->stock);
                    $subtotal = $product->pivot->price * $quantity;
                    $sale->products()->attach($product->id, [
                        'price' => $product->pivot->price,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal,
                    ]);
                    $total += $subtotal;
                }

                $sale->total = $total;
                $sale->save();
            }
        }
    }
}
