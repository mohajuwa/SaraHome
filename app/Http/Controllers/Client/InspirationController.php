<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Inspiration;
use Illuminate\View\View;

class InspirationController extends Controller
{
    public function index(\Illuminate\Http\Request $request): View
    {
        $inspirations = Inspiration::latest()->get();

        return view('client.inspiration', [
            'inspirations' => $inspirations,
            'tags' => $inspirations->pluck('tag')->unique()->values(),
            'favoriteIds' => $request->user()->favorites()->whereNotNull('inspiration_id')->pluck('inspiration_id')->all(),
        ]);
    }
}
