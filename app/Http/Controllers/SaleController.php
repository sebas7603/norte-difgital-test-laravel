<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sale\IndexSaleRequest;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaleController extends Controller
{
    /**
     * List all sales
     */
    public function index(IndexSaleRequest $request): JsonResponse
    {
        $startDate = $request->query('start_date', null);
        $endDate = $request->query('end_date', null);
        $itemsPerPage = $request->query('items', 10);
        $sales = Sale::withCount('products')
            ->when($startDate, function (Builder $query, string $startDate) {
                $query->where('created_at', '>=', Carbon::parse($startDate)->startOfDay());
            })
            ->when($endDate, function (Builder $query, string $endDate) {
                $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay());
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
                $productModel = $sale->branch->products()->where('product_id', $product['id'])->first();
                $sale->products()->attach($product['id'], [
                    'price' => $productModel->pivot->price,
                    'quantity' => $product['quantity'],
                    'subtotal' => $product['quantity'] * $productModel->pivot->price,
                ]);
                $total += ($product['quantity'] * $productModel->pivot->price);
                $productModel->pivot->stock -= $product['quantity'];
                $productModel->pivot->save();
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
            ], 201);
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
