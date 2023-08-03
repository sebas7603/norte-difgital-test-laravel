<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder;

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
