<?php

namespace App\Services\Archives;

use App\Models\Archive;
use Illuminate\Support\Facades\Storage;

class ArchivesService
{
    public function find(int $id): ?Archive
    {
        return Archive::find($id);
    }

    public function all()
    {
        return Archive::latest()->get();
    }

    public function byType(string $type)
    {
        return Archive::where('type', $type)->latest()->get();
    }
}
