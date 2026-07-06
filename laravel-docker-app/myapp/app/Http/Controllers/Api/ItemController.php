<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index()
    {
        $items = DB::table('items')->get();
        return ItemResource::collection($items);
    }

    public function show(int $id)
    {
        $item = DB::table('items')->where('id', $id)->first();

        if (! $item) {
            abort(404);
        }

        return new ItemResource($item);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|integer|min:0',
        ]);

        $id = DB::table('items')->insertGetId($validated);
        $item = DB::table('items')->where('id', $id)->first();

        return new ItemResource($item);
    }
}
