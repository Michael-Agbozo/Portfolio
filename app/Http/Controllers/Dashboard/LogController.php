<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    /** How much of the log file (from the end) to read and display. */
    private const TAIL_BYTES = 1024 * 1024;

    public function index()
    {
        $path = storage_path('logs/laravel.log');
        $entries = [];
        $size = 0;

        if (File::exists($path)) {
            $size = File::size($path);
            $entries = $this->parseEntries($this->readTail($path, self::TAIL_BYTES));
        }

        return view('dashboard.logs.index', [
            'entries' => $entries,
            'size' => $size,
            'truncated' => $size > self::TAIL_BYTES,
        ]);
    }

    public function clear()
    {
        $path = storage_path('logs/laravel.log');

        if (File::exists($path)) {
            File::put($path, '');
        }

        return redirect()->route('dashboard.logs.index')->with('success', 'Log file cleared.');
    }

    /** Read the last $bytes bytes of a (possibly large) file. */
    private function readTail(string $path, int $bytes): string
    {
        $size = File::size($path);
        $start = max(0, $size - $bytes);

        $handle = fopen($path, 'r');
        fseek($handle, $start);
        $contents = stream_get_contents($handle);
        fclose($handle);

        // The first line may be a partial entry cut off mid-way — drop it.
        if ($start > 0 && ($newline = strpos($contents, "\n")) !== false) {
            $contents = substr($contents, $newline + 1);
        }

        return $contents;
    }

    /** Split raw log text into individual entries (newest first). */
    private function parseEntries(string $contents): array
    {
        $pattern = '/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.*)$/m';
        preg_match_all($pattern, $contents, $matches, PREG_OFFSET_CAPTURE);

        $entries = [];
        $count = count($matches[0]);

        for ($i = 0; $i < $count; $i++) {
            $start = $matches[0][$i][1];
            $end = $i + 1 < $count ? $matches[0][$i + 1][1] : strlen($contents);

            $entries[] = [
                'time' => $matches[1][$i][0],
                'level' => strtoupper($matches[3][$i][0]),
                'message' => trim($matches[4][$i][0]),
                'full' => trim(substr($contents, $start, $end - $start)),
            ];
        }

        return array_reverse($entries);
    }
}
