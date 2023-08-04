<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sale\StoreSaleRequest;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * List all sales
     */
    public function index(Request $request): JsonResponse
    {
        $fromDate = $request->query('from', null);
        $toDate = $request->query('to', null);
        $itemsPerPage = $request->query('items', 10);
        $sales = Sale::withCount('products')
            ->when($fromDate, function (Builder $query, string $fromDate) {
                $query->where('created_at', '>=', $fromDate);
            })
            ->when($toDate, function (Builder $query, string $toDate) {
                $query->where('created_at', '<=', $toDate);
            })
            ->withCount('products')
            ->with('branch')
            ->with('salesman')
            ->with('salesman.client')
            ->with('client')
            ->orderBy('created_at', 'desc')
            ->paginate($itemsPerPage);
        return response()->json($sales, 200);
    }

    /**
     * Store a new Sale
     */
    public function store(StoreSaleRequest $request): JsonResponse
    {
        $total = 0;
        try {
            DB::beginTransaction();
            $sale = Sale::create($request->all());

            foreach ($request->products as $product) {
                $price = $sale->branch->products()->where('product_id', $product['id'])->first()->pivot->price;
                $sale->products()->attach($product['id'], [
                    'price' => $price,
                    'quantity' => $product['quantity'],
                    'subtotal' => $product['quantity'] * $price,
                ]);
                $total += ($product['quantity'] * $price);
            }

            $sale->total = $total;
            $sale->save();
            DB::commit();
            return response()->json([
                'data' => $sale->load([
                    'branch',
                    'salesman',
                    'salesman.client',
                    'client',
                    'products',
                ])
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => 'Ups! There was a server error.',
                'error' => [
                    'class' => get_class($th),
                    'message' => $th->getMessage(),
                    'code' => $th->getCode(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine(),
                    'trace' => $th->getTrace()
                ]
            ], 500);
        }
    }

    /**
     * Retrieve a sale based on the ID
     */
    public function show(Request $request, $id): JsonResponse
    {
        $sale = Sale::find($id);
        if (!$sale) return response()->json([ 'message' => 'Sale ' . $id . ' does not exist.' ], 404);

        return response()->json([
            'data' => $sale->load([
                'branch',
                'salesman',
                'salesman.client',
                'client',
                'products',
            ])
        ], 200);
    }
}
