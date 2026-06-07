<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $folders = ['designs', 'projects'];
        $files   = [];

        foreach ($folders as $folder) {
            foreach (Storage::disk('public')->files($folder) as $path) {
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                    continue;
                }
                $files[] = [
                    'path'    => $path,
                    'url'     => '/storage/' . $path,
                    'folder'  => $folder,
                    'name'    => basename($path),
                    'size'    => Storage::disk('public')->size($path),
                    'modified'=> Storage::disk('public')->lastModified($path),
                ];
            }
        }

        usort($files, fn($a, $b) => $b['modified'] - $a['modified']);

        return view('dashboard.media.index', compact('files'));
    }

    public function destroy(string $filename)
    {
        $path = ltrim($filename, '/');

        if (str_contains($path, '..') || !preg_match('#^(designs|projects)/[A-Za-z0-9._-]+$#', $path)) {
            abort(403);
        }

        Storage::disk('public')->delete($path);

        return back()->with('success', 'File deleted.');
    }
}
