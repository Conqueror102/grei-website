<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InteriorController extends Controller
{
    public function index(Request $request)
    {
        $sector = $request->validate([
            'sector' => ['nullable', Rule::in(array_keys(Project::SECTORS))],
        ])['sector'] ?? null;

        return view('interiors.index', [
            'projects' => Project::ordered()->when($sector, fn ($q) => $q->where('sector', $sector))->get(),
            'sector' => $sector,
        ]);
    }

    public function show(Project $project)
    {
        return view('interiors.show', [
            'project' => $project,
            'next' => Project::ordered()->whereKeyNot($project->id)->first(),
        ]);
    }
}
