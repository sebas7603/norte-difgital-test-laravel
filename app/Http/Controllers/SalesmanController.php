<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Salesman;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SalesmanController extends Controller
{
    /**
     * List all salesmen
     */
    public function index(Request $request): JsonResponse
    {
        $itemsPerPage = $request->query('items', 10);
        $salesmen = Client::has('salesman')
            ->withAggregate('salesman', 'email')
            ->withAggregate('salesman', 'born_date')
            ->orderBy('name', 'asc')
            ->paginate($itemsPerPage);
        return response()->json($salesmen, 200);
    }

    /**
     * Retrieve a salesman based on the ID
     */
    public function show(Request $request, $id): JsonResponse
    {
        $salesman = Salesman::find($id);
        if (!$salesman) return response()->json([ 'message' => 'Salesman ' . $id . ' does not exist.' ], 404);

        return response()->json([
            'data' => $salesman->load([
                'client',
                'sales' => function ($query) {
                    $query->orderBy('created_at', 'desc')->limit(5);
                },
            ])
        ], 200);
    }
}
