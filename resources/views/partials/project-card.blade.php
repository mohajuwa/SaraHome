@php
    $statusStyles = [
        'completed' => 'bg-pine-soft text-pine',
        'in_review' => 'bg-clay-soft text-clay',
        'new' => 'bg-ochre-soft text-ochre',
    ][$project->status] ?? 'bg-ochre-soft text-ochre';
@endphp
<a href="{{ route('client.projects.show', $project) }}"
   class="card group overflow-hidden transition duration-300 hover:-translate-y-1 hover:shadow-soft">
    <div class="relative h-36 overflow-hidden">
        @if ($project->image_path)
            <img src="{{ \Storage::url($project->image_path) }}" alt="{{ $project->name }}"
                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="h-full w-full"
                 style="background:linear-gradient(135deg,#EFE5D8 0%, #E7D3BE 45%, #C15F3C 130%);"></div>
        @endif
        <span class="pill absolute right-3 top-3 {{ $statusStyles }}">{{ $project->statusLabel() }}</span>
    </div>
    <div class="p-4">
        <h3 class="font-bold text-ink">{{ $project->name }}</h3>
        <p class="mt-0.5 text-sm text-muted">{{ $project->style }} · {{ $project->room_type }}</p>
        <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-sand">
            <div class="h-full rounded-full bg-clay" style="width: {{ $project->progress }}%"></div>
        </div>
        <p class="mt-2 text-xs text-muted">اكتمل {{ $project->progress }}% من التصميم</p>
    </div>
</a>
