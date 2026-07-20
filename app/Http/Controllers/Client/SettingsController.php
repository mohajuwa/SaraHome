<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(Request $request): View
    {
        return view('client.settings', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'phone' => ['nullable', 'string', 'max:20'],
            'preferred_style' => ['nullable', 'string', 'max:40'],
            'budget_range' => ['nullable', 'string', 'max:40'],
        ]);

        $request->user()->update($data);

        return back()->with('status', 'تم حفظ التفضيلات بنجاح.');
    }
}
