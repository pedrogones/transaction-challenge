<?php

namespace App\Services\Archives;
use App\Models\Archive;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ArchiveUploadService
{
    public function upload($file,$type, $visibility = 'private', $attachable = null ): Archive {

        $disk = $visibility === 'public' ? 'public' : 'local';
        $path = $file->store('archives/' . $type, $disk);

        return $this->create(file: $file, path: $path, disk: $disk, type: $type, visibility: $visibility, attachable: $attachable);
    }

    public function create($file, $path, $disk, $type, $visibility, $attachable = null ): Archive {

        $archive = new Archive();
        $archive->path          = $path;
        $archive->disk          = $disk;
        $archive->type          = $type;
        $archive->visibility    = $visibility;
        $archive->original_name = $file->getClientOriginalName();
        $archive->extension     = $file->getClientOriginalExtension();
        $archive->mime_type     = $file->getMimeType();
        $archive->size          = $file->getSize();

        if ($attachable) {
            $archive->attachable()->associate($attachable);
        }

        $archive->save();

        return $archive;
    }
    public function delete(Archive $archive): bool
    {
        if (Storage::disk($archive->disk)->exists($archive->path)) {
            Storage::disk($archive->disk)->delete($archive->path);
        }

        return $archive->delete();
    }


}
