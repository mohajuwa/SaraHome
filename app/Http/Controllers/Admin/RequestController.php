<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RequestController extends Controller
{
    public function index(): View
    {
        $projects = Project::with('user')->latest()->get();

        $columns = [
            'new' => $projects->where('status', 'new')->values(),
            'in_review' => $projects->where('status', 'in_review')->values(),
            'completed' => $projects->where('status', 'completed')->values(),
        ];

        return view('admin.requests', ['columns' => $columns]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,in_review,completed'],
        ]);

        $progress = match ($data['status']) {
            'completed' => 100,
            'in_review' => max($project->progress, 45),
            default => 12,
        };

        $project->update(['status' => $data['status'], 'progress' => $progress]);

        return back()->with('status', 'تم تحديث حالة المشروع.');
    }
}
