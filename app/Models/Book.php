<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'pdf_path', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    /** Public reader link — this is what the QR code opens. */
    public function readerUrl(): string
    {
        return route('books.show', $this->slug);
    }

    public function pdfUrl(): string
    {
        return '/storage/'.$this->pdf_path;
    }

    /** PDF size in bytes, or null when the file is missing. */
    public function pdfSize(): ?int
    {
        $disk = Storage::disk('public');

        return $disk->exists($this->pdf_path) ? $disk->size($this->pdf_path) : null;
    }
}
