<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BranchController extends Controller
{
    /**
     * List all branches
     */
    public function index(Request $request): JsonResponse
    {
        $itemsPerPage = $request->query('items', 10);
        $branches = Branch::withCount('products')->orderBy('country', 'asc')->paginate($itemsPerPage);
        return response()->json($branches, 200);
    }

    /**
     * Retrieve a branch based on the ID
     */
    public function show(Request $request, $id): JsonResponse
    {
        $branch = Branch::find($id);
        if (!$branch) return response()->json([ 'message' => 'Branch ' . $id . ' does not exist.' ], 404);

        return response()->json([
            'data' => $branch->load([
                'products' => function ($query) {
                    $query->limit(5);
                },
                'sales' => function ($query) {
                    $query->orderBy('created_at', 'desc')->limit(5);
                },
            ])
        ], 200);
    }
}
