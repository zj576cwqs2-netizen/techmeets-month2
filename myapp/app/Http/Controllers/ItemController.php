<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function show($id)
    {
        return response()->json([
            'data' => [
                'id' => (int) $id,
                'name' => '商品A',
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
        ]);

        return response()->json([
            'data' => $validated,
        ], 201);
    }
}
