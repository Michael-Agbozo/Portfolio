<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\Media;
use App\Models\Project;
use App\Support\ImageCompressor;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $allFiles = $this->libraryFiles();

        $counts = [
            'all'      => count($allFiles),
            'projects' => count(array_filter($allFiles, fn ($f) => $f['folder'] === 'projects')),
            'designs'  => count(array_filter($allFiles, fn ($f) => $f['folder'] === 'designs')),
            'unused'   => count(array_filter($allFiles, fn ($f) => $f['folder'] === 'unused')),
        ];

        $filter = $request->query('filter', 'all');
        $filtered = in_array($filter, ['projects', 'designs', 'unused'], true)
            ? array_values(array_filter($allFiles, fn ($f) => $f['folder'] === $filter))
            : $allFiles;

        $totalSize = array_sum(array_column($filtered, 'size'));

        $perPage = 24;
        $page    = max(1, (int) $request->query('page', 1));
        $files   = new LengthAwarePaginator(
            array_slice($filtered, ($page - 1) * $perPage, $perPage),
            count($filtered),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('dashboard.media.index', compact('files', 'counts', 'filter', 'totalSize'));
    }

    public function storeTemp(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate(['file' => 'required|mimes:jpg,jpeg,png,webp,gif|max:102400']);
        $path = $request->file('file')->store('media', 'public');
        ImageCompressor::compress(Storage::disk('public')->path($path));
        return response()->json(['path' => '/storage/' . $path]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'files'     => 'required|array|min:1',
            'files.*'   => 'mimes:jpg,jpeg,png,webp,gif|max:102400',
        ]);

        foreach ($request->file('files') as $file) {
            $path = $file->store('media', 'public');
            ImageCompressor::compress(Storage::disk('public')->path($path));
        }

        $count = count($request->file('files'));

        return back()->with('success', $count === 1 ? 'File uploaded.' : "{$count} files uploaded.");
    }

    public static function libraryFiles(): array
    {
        $folders = ['media', 'designs', 'projects'];
        $files   = [];

        $designUrls  = Design::pluck('src')->filter()->all();
        $projectUrls = Project::withTrashed()
            ->get(['feature_image', 'images'])
            ->flatMap(fn ($p) => array_filter(array_merge([$p->feature_image], $p->images ?? [])))
            ->all();
        $meta = Media::all()->keyBy('path');

        $disk     = Storage::disk('public');
        $diskRoot = $disk->path('');

        foreach ($folders as $folder) {
            foreach ($disk->files($folder) as $path) {
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                    continue;
                }
                $url = '/storage/' . $path;

                if (in_array($url, $projectUrls, true)) {
                    $category = 'projects';
                } elseif (in_array($url, $designUrls, true)) {
                    $category = 'designs';
                } else {
                    $category = 'unused';
                }

                $record = $meta->get($path);
                $stat   = @stat($diskRoot . $path);

                $files[] = [
                    'path'     => $path,
                    'url'      => $url,
                    'folder'   => $category,
                    'name'     => basename($path),
                    'title'    => $record->name ?? '',
                    'alt'      => $record->alt ?? '',
                    'size'     => $stat['size'] ?? 0,
                    'modified' => $stat['mtime'] ?? 0,
                ];
            }
        }

        usort($files, fn($a, $b) => $b['modified'] - $a['modified']);

        return $files;
    }

    public function update(Request $request, string $filename)
    {
        $path = ltrim($filename, '/');

        if (str_contains($path, '..') || !preg_match('#^(media|designs|projects)/[A-Za-z0-9._-]+$#', $path)) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'nullable|string|max:200',
            'alt'  => 'nullable|string|max:200',
        ]);

        Media::updateOrCreate(['path' => $path], [
            'name' => $data['name'] ?? null,
            'alt'  => $data['alt'] ?? null,
        ]);

        return back()->with('success', 'Media details saved.');
    }

    public function destroy(string $filename)
    {
        $path = ltrim($filename, '/');

        if (str_contains($path, '..') || !preg_match('#^(media|designs|projects)/[A-Za-z0-9._-]+$#', $path)) {
            abort(403);
        }

        $url = '/storage/' . $path;

        $usedByProject = Project::where('feature_image', $url)->exists()
            || Project::whereJsonContains('images', $url)->exists();
        $usedByDesign  = Design::where('src', $url)->exists();

        if ($usedByProject || $usedByDesign) {
            return back()->withErrors(['file' => 'This image is still used by a project or design. Remove it from there first.']);
        }

        Storage::disk('public')->delete($path);
        Media::where('path', $path)->delete();

        return back()->with('success', 'File deleted.');
    }
}
