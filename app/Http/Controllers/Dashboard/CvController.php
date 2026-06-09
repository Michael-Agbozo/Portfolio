<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CvController extends Controller
{
    private const DIRECTORY = 'cv';
    private const FILENAME = 'michael-agbozo-cv.pdf';

    public function show()
    {
        $path = public_path(self::DIRECTORY.'/'.self::FILENAME);
        $cv = [
            'exists' => is_file($path),
            'url' => asset(self::DIRECTORY.'/'.self::FILENAME),
            'size' => is_file($path) ? filesize($path) : null,
            'updated_at' => is_file($path) ? filemtime($path) : null,
        ];

        return view('dashboard.cv.show', compact('cv'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'cv' => 'required|file|mimes:pdf|max:10240',
        ]);

        $directory = public_path(self::DIRECTORY);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $request->file('cv')->move($directory, self::FILENAME);

        return back()->with('success', 'CV updated. The public download button now uses the new file.');
    }
}
