<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * List all products
     */
    public function index(Request $request): JsonResponse
    {
        $itemsPerPage = $request->query('items', 10);
        $products = Product::withCount('sales')->with('supplier')->orderBy('name', 'asc')->paginate($itemsPerPage);
        return response()->json($products, 200);
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
