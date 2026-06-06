<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['name', 'email', 'subject', 'message'];

    protected $casts = ['read_at' => 'datetime'];

    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }

    public function markRead(): void
    {
        if ($this->isUnread()) {
            $this->update(['read_at' => now()]);
        }
    }
}
