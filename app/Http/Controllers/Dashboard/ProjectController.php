<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('sort_order')->orderBy('id')->get();
        return view('dashboard.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('dashboard.projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'num'        => 'required|string|max:40',
            'category'   => 'required|in:design,development',
            'title'      => 'required|string|max:150',
            'meta'       => 'nullable|string|max:300',
            'body'       => 'nullable|string',
            'images'     => 'nullable|string',
            'tags'       => 'nullable|string',
            'url'        => 'nullable|url|max:300',
            'sort_order' => 'nullable|integer',
        ]);

        $data['tags'] = $this->parseTags($data['tags'] ?? '');
        $data['images'] = $this->parseLines($data['images'] ?? '');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Project::create($data);

        return redirect()->route('dashboard.projects.index')->with('success', 'Project added.');
    }

    public function edit(Project $project)
    {
        return view('dashboard.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'num'        => 'required|string|max:40',
            'category'   => 'required|in:design,development',
            'title'      => 'required|string|max:150',
            'meta'       => 'nullable|string|max:300',
            'body'       => 'nullable|string',
            'images'     => 'nullable|string',
            'tags'       => 'nullable|string',
            'url'        => 'nullable|url|max:300',
            'sort_order' => 'nullable|integer',
        ]);

        $data['tags'] = $this->parseTags($data['tags'] ?? '');
        $data['images'] = $this->parseLines($data['images'] ?? '');
        $data['sort_order'] = $data['sort_order'] ?? $project->sort_order;

        $project->update($data);

        return redirect()->route('dashboard.projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('dashboard.projects.index')->with('success', 'Project deleted.');
    }

    private function parseTags(string $raw): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $raw))));
    }

    private function parseLines(string $raw): array
    {
        return array_values(array_filter(array_map('trim', explode("\n", $raw))));
    }
}
