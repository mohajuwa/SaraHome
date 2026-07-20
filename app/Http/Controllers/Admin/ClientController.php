<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = User::where('role', 'client')
            ->withCount('projects')
            ->withMax('projects', 'updated_at')
            ->orderByDesc('projects_max_updated_at')
            ->get();

        return view('admin.clients', ['clients' => $clients]);
    }
}
