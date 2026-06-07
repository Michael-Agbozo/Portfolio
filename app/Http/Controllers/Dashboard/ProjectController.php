<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Support\ImageCompressor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('id', 'desc')->get();
        return view('dashboard.projects.index', compact('projects'));
    }

    public function create()
    {
        $mediaFiles = MediaController::libraryFiles();
        return view('dashboard.projects.create', compact('mediaFiles'));
    }

    public function store(Request $request)
    {
        $data = $this->validateProject($request);

        $data['tags'] = $this->parseTags($data['tags'] ?? '');
        $data['feature_image'] = $this->resolveFeatureImage($request, null);
        $data['images'] = $this->resolveGalleryImages($request, $data['images'] ?? '');
        $data['slug'] = $this->uniqueSlug($data['title'], null);

        Project::create($data);

        return redirect()->route('dashboard.projects.index')->with('success', 'Project added.');
    }

    public function edit(Project $project)
    {
        $mediaFiles = MediaController::libraryFiles();
        return view('dashboard.projects.edit', compact('project', 'mediaFiles'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->validateProject($request);

        $data['tags'] = $this->parseTags($data['tags'] ?? '');
        $data['feature_image'] = $this->resolveFeatureImage($request, $project);
        $data['images'] = $this->resolveGalleryImages($request, $data['images'] ?? '');

        if ($data['title'] !== $project->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $project);
        }

        $project->update($data);

        return redirect()->route('dashboard.projects.index')->with('success', 'Project updated.');
    }

    public function toggleActive(Project $project)
    {
        $project->update(['active' => ! $project->active]);

        return back()->with('success', $project->active ? 'Project marked active.' : 'Project marked inactive.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('dashboard.projects.index')->with('success', 'Project deleted.');
    }

    private function validateProject(Request $request): array
    {
        return $request->validate([
            'num'               => 'required|string|max:40',
            'category'          => 'required|in:design,development',
            'title'             => 'required|string|max:150',
            'meta'              => 'nullable|string|max:300',
            'body'              => 'nullable|string',
            'feature_image_file' => 'nullable|image|max:51200',
            'feature_image_path' => 'nullable|string|max:500',
            'gallery_files'     => 'nullable|array',
            'gallery_files.*'   => 'image|max:51200',
            'images'            => 'nullable|string',
            'tags'              => 'nullable|string',
            'url'               => 'nullable|url|max:300',
        ]);
    }

    /**
     * Build a URL-friendly slug from the title (e.g. "Emefs Foods" -> "emefs-foods"),
     * adding "-2", "-3", etc. if another project already uses that slug.
     */
    private function uniqueSlug(string $title, ?Project $ignore): string
    {
        $base = \Illuminate\Support\Str::slug($title) ?: 'project';
        $slug = $base;
        $suffix = 2;

        while (
            Project::where('slug', $slug)
                ->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))
                ->exists()
        ) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    private function parseTags(string $raw): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $raw))));
    }

    /**
     * Feature image can come from a freshly uploaded file, a pasted URL/storage
     * path, or a path picked from the media library (also arrives as a path).
     */
    private function resolveFeatureImage(Request $request, ?Project $existing): ?string
    {
        if ($request->hasFile('feature_image_file')) {
            $path = $request->file('feature_image_file')->store('projects', 'public');
            ImageCompressor::compress(Storage::disk('public')->path($path));
            return '/storage/' . $path;
        }

        $path = trim((string) $request->input('feature_image_path'));

        if ($path !== '') {
            $this->assertValidImagePath('feature_image_path', $path);
            return $path;
        }

        return $existing?->feature_image;
    }

    /**
     * Gallery is the union of: newly uploaded files, plus whatever lines remain
     * in the "images" textarea (manually pasted URLs/paths or library picks
     * appended there by the picker).
     */
    private function resolveGalleryImages(Request $request, string $raw): array
    {
        $uploaded = [];
        foreach ($request->file('gallery_files', []) as $file) {
            $path = $file->store('projects', 'public');
            ImageCompressor::compress(Storage::disk('public')->path($path));
            $uploaded[] = '/storage/' . $path;
        }

        $pasted = $this->parseImages($raw);

        return array_values(array_unique(array_merge($pasted, $uploaded)));
    }

    private function parseImages(string $raw): array
    {
        $lines = array_values(array_filter(array_map('trim', explode("\n", $raw))));

        foreach ($lines as $line) {
            $this->assertValidImagePath('images', $line);
        }

        return $lines;
    }

    private function assertValidImagePath(string $field, string $value): void
    {
        if (! \App\Support\ImagePathValidator::isValid($value)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                $field => "Invalid image entry: \"{$value}\" — each must be a full image URL or a /storage/ path.",
            ]);
        }
    }
}
