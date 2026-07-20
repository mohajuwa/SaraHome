<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function toggle(Request $request): JsonResponse
    {
        $data = $request->validate([
            'type' => ['required', 'in:product,inspiration'],
            'id' => ['required', 'integer'],
        ]);

        $column = $data['type'].'_id';

        $existing = $request->user()->favorites()->where($column, $data['id'])->first();

        if ($existing) {
            $existing->delete();

            return response()->json(['on' => false]);
        }

        $request->user()->favorites()->create([$column => $data['id']]);

        return response()->json(['on' => true]);
    }

    public function index(Request $request): View
    {
        $favorites = $request->user()->favorites()->with('product.category', 'inspiration')->latest()->get();

        return view('client.favorites', [
            'products' => $favorites->pluck('product')->filter()->values(),
            'inspirations' => $favorites->pluck('inspiration')->filter()->values(),
        ]);
    }
}
