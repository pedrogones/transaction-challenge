<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Archive extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'path',
        'disk',
        'type',
        'visibility',
        'original_name',
        'extension',
        'mime_type',
        'size',
        'status'
    ];

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

}
