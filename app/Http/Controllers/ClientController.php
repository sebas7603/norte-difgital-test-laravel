<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    /**
     * List all clients
     */
    public function index(Request $request): JsonResponse
    {
        $itemsPerPage = $request->query('items', 10);
        $clients = Client::withCount('purchases')->orderBy('name', 'asc')->paginate($itemsPerPage);
        return response()->json($clients, 200);
    }

    /**
     * Retrieve a client based on the ID
     */
    public function show(Request $request, $id): JsonResponse
    {
        $client = Client::find($id);
        if (!$client) return response()->json([ 'message' => 'Client ' . $id . ' does not exist.' ], 404);

        return response()->json([
            'data' => $client->load([
                'purchases' => function ($query) {
                    $query->orderBy('created_at', 'desc')->limit(5)->withCount('products')->with('branch')->with('salesman');
                },
            ])
        ], 200);
    }
}
