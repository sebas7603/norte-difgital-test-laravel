<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class ProductController extends Controller
{
    /**
     * List all products
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $branchId = $request->query('branch', null);
            $supplierId = $request->query('supplier', null);
            $itemsPerPage = $request->query('items', 10);
            $products = Product::withCount('sales')
                ->when($branchId, function (Builder $query, int $branchId) {
                    $query->leftJoin('branch_product', function (JoinClause $join) use ($branchId) {
                        $join->on('branch_product.product_id', '=', 'products.id');
                    })->where('branch_product.branch_id', '=', $branchId);
                })
                ->when($supplierId, function (Builder $query, int $supplierId) {
                    $query->where('products.supplier_id', '=', $supplierId);
                })
                ->with('supplier')
                ->with('branches')
                ->orderBy('name', 'asc')
                ->paginate($itemsPerPage);
            return response()->json($products, 200);
        } catch (\Throwable $th) {
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
     * Retrieve a product based on the ID
     */
    public function show(Request $request, $id): JsonResponse
    {
        $product = Product::withCount('sales')->find($id);
        if (!$product) return response()->json([ 'message' => 'Product ' . $id . ' does not exist.' ], 404);

        return response()->json([
            'data' => $product->load([
                'supplier',
                'branches',
            ])
        ], 200);
    }
}
