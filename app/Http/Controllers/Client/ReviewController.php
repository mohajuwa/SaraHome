<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:400'],
        ]);

        $product->reviews()->updateOrCreate(
            ['user_id' => $request->user()->id],
            ['rating' => $data['rating'], 'comment' => $data['comment'] ?? null]
        );

        return back()->with('status', 'شكراً لتقييمك 🌟');
    }
}
