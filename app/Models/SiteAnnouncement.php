<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SiteAnnouncement extends Model
{
    protected $fillable = [
        'enabled',
        'message',
        'reopen_label',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public static function current(): ?self
    {
        return static::query()->orderBy('id')->first();
    }

    public function isActive(?Carbon $at = null): bool
    {
        if (! $this->enabled) {
            return false;
        }

        $message = trim((string) $this->message);
        if ($message === '') {
            return false;
        }

        $at ??= now();

        if ($this->starts_at && $at->lt($this->starts_at)) {
            return false;
        }

        if ($this->ends_at && $at->gt($this->ends_at)) {
            return false;
        }

        return true;
    }

    public function dismissToken(): string
    {
        return sha1((string) $this->id.'|'.optional($this->updated_at)->timestamp.'|'.md5((string) $this->message));
    }

    public function reopenButtonLabel(): string
    {
        $label = trim((string) $this->reopen_label);

        return $label !== '' ? $label : 'Mostra avviso';
    }
}
