<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * List all suppliers
     */
    public function index(Request $request): JsonResponse
    {
        $itemsPerPage = $request->query('items', 10);
        $suppliers = Supplier::withCount('products')->orderBy('name', 'asc')->paginate($itemsPerPage);
        return response()->json($suppliers, 200);
    }

    /**
     * Retrieve a supplier based on the ID
     */
    public function show(Request $request, $id): JsonResponse
    {
        $supplier = Supplier::find($id);
        if (!$supplier) return response()->json([ 'message' => 'Supplier with id ' . $id . ' does not exist.' ], 404);

        return response()->json([
            'data' => $supplier->load([
                'products' => function ($query) {
                    $query->limit(5);
                },
            ])
        ], 200);
    }
}
