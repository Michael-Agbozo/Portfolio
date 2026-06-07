<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\Media;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $files = $this->libraryFiles();

        return view('dashboard.media.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files'     => 'required|array|min:1',
            'files.*'   => 'image|max:8192',
        ]);

        foreach ($request->file('files') as $file) {
            $file->store('media', 'public');
        }

        $count = count($request->file('files'));

        return back()->with('success', $count === 1 ? 'File uploaded.' : "{$count} files uploaded.");
    }

    public static function libraryFiles(): array
    {
        $folders = ['media', 'designs', 'projects'];
        $files   = [];

        $designUrls  = Design::pluck('src')->filter()->all();
        $projectUrls = Project::all()->flatMap(fn ($p) => array_filter(array_merge(
            [$p->feature_image],
            $p->images ?? []
        )))->all();
        $meta = Media::all()->keyBy('path');

        foreach ($folders as $folder) {
            foreach (Storage::disk('public')->files($folder) as $path) {
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

                $files[] = [
                    'path'    => $path,
                    'url'     => $url,
                    'folder'  => $category,
                    'name'    => basename($path),
                    'title'   => $record->name ?? '',
                    'alt'     => $record->alt ?? '',
                    'size'    => Storage::disk('public')->size($path),
                    'modified'=> Storage::disk('public')->lastModified($path),
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

        Storage::disk('public')->delete($path);

        return back()->with('success', 'File deleted.');
    }
}
