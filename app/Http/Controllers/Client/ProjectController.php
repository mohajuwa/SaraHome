<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\DesignGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        return view('client.projects.index', [
            'projects' => $request->user()->projects()->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'room_type' => ['required', 'string', 'max:40'],
            'style' => ['required', 'string', 'max:40'],
            'budget' => ['required', 'string', 'max:40'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('rooms', 'public');
        }

        $project = $request->user()->projects()->create([
            'name' => $data['name'],
            'room_type' => $data['room_type'],
            'style' => $data['style'],
            'budget' => $data['budget'],
            'status' => 'new',
            'progress' => 12,
            'image_path' => $path,
        ]);

        return redirect()
            ->route('client.projects.show', $project)
            ->with('status', 'تم حفظ طلبك. اضغطي «أنشئ تصميمي» لعرض المقترح.');
    }

    public function show(Request $request, Project $project): View
    {
        abort_unless($project->user_id === $request->user()->id, 403);

        $project->load('design', 'messages.user');

        return view('client.projects.show', [
            'project' => $project,
            'suggestedProducts' => $project->design ? $this->suggestedProducts($project) : collect(),
        ]);
    }

    /** Store products that fit the project's room type — bridges the AI design and the store. */
    protected function suggestedProducts(Project $project)
    {
        $slugs = [
            'غرفة المعيشة' => ['sofas', 'curtains', 'fabric'],
            'غرفة النوم' => ['beds', 'vanities', 'wardrobes', 'nightstands', 'chiffoniers'],
            'مكتب منزلي' => ['sofas', 'curtains', 'wood'],
            'غرفة طعام' => ['kitchens', 'curtains', 'wood'],
        ][$project->room_type] ?? ['sofas', 'curtains'];

        return \App\Models\Product::whereHas('category', fn ($q) => $q->whereIn('slug', $slugs))
            ->orderByDesc('is_featured')
            ->take(3)
            ->get();
    }

    public function generate(Request $request, Project $project, DesignGenerator $generator): RedirectResponse
    {
        abort_unless($project->user_id === $request->user()->id, 403);

        $generator->generate($project);

        if ($project->status === 'new') {
            $project->update(['status' => 'in_review', 'progress' => max($project->progress, 70)]);
        }

        return redirect()
            ->route('client.projects.show', $project)
            ->with('status', 'تم إنشاء تصوّر التصميم بنجاح 🌿');
    }
}
