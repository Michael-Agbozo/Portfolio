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
            // read_at is system-managed, not user-fillable — forceFill bypasses
            // mass-assignment protection so this actually persists.
            $this->forceFill(['read_at' => now()])->save();
        }
    }

    public function markUnread(): void
    {
        $this->forceFill(['read_at' => null])->save();
    }
}
