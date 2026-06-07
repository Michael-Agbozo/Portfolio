<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Support\ImageCompressor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DesignController extends Controller
{
    public function index()
    {
        $designs = Design::orderBy('id', 'desc')->get();
        return view('dashboard.designs.index', compact('designs'));
    }

    public function create()
    {
        $mediaFiles = MediaController::libraryFiles();
        return view('dashboard.designs.create', compact('mediaFiles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|max:51200',
            'src'   => 'nullable|url|max:500',
            'alt'   => 'required|string|max:200',
        ]);

        if (!$request->hasFile('image') && !$request->filled('src')) {
            return back()->withErrors(['src' => 'Please upload an image file or paste an image URL.'])->withInput();
        }

        $src = $this->resolveImageSrc($request, null);

        Design::create([
            'src' => $src,
            'alt' => $request->alt,
        ]);

        return redirect()->route('dashboard.designs.index')->with('success', 'Design added.');
    }

    public function show(Design $design)
    {
        return view('dashboard.designs.show', compact('design'));
    }

    public function edit(Design $design)
    {
        $mediaFiles = MediaController::libraryFiles();
        return view('dashboard.designs.edit', compact('design', 'mediaFiles'));
    }

    public function update(Request $request, Design $design)
    {
        $request->validate([
            'image' => 'nullable|image|max:51200',
            'src'   => 'nullable|url|max:500',
            'alt'   => 'required|string|max:200',
        ]);

        $src = $this->resolveImageSrc($request, $design);

        $design->update([
            'src' => $src,
            'alt' => $request->alt,
        ]);

        return redirect()->route('dashboard.designs.index')->with('success', 'Design updated.');
    }

    public function destroy(Design $design)
    {
        $this->deleteLocalFile($design->src);
        $design->delete();
        return redirect()->route('dashboard.designs.index')->with('success', 'Design removed.');
    }

    private function resolveImageSrc(Request $request, ?Design $existing): string
    {
        if ($request->hasFile('image')) {
            if ($existing) {
                $this->deleteLocalFile($existing->src);
            }
            $path = $request->file('image')->store('designs', 'public');
            ImageCompressor::compress(Storage::disk('public')->path($path));
            return '/storage/' . $path;
        }

        if ($request->filled('src')) {
            return $request->src;
        }

        return $existing?->src ?? '';
    }

    private function deleteLocalFile(string $src): void
    {
        if (str_starts_with($src, '/storage/')) {
            Storage::disk('public')->delete(ltrim(str_replace('/storage', '', $src), '/'));
        }
    }
}
