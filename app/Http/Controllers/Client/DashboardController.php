<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $projects = $request->user()->projects()->latest()->get();

        return view('client.dashboard', [
            'projects' => $projects,
            'recent' => $projects->take(3),
        ]);
    }
}
