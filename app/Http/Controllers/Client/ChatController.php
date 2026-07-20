<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function index(Request $request): View
    {
        $project = $request->user()->projects()->latest()->first();

        $messages = $project
            ? $project->messages()->with('user')->get()->sortBy('created_at')->values()
            : collect();

        return view('client.chat', [
            'project' => $project,
            'messages' => $messages,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $project = Project::findOrFail($data['project_id']);
        abort_unless($project->user_id === $request->user()->id, 403);

        Message::create([
            'project_id' => $project->id,
            'user_id' => $request->user()->id,
            'body' => $data['body'],
            'is_from_designer' => false,
        ]);

        return redirect()->route('client.chat');
    }
}
