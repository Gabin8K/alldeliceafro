<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TemporaryFileService
{
    public static function store(UploadedFile $file, string $id = ''): array
    {
        $date = Carbon::now('Europe/Berlin');
        $nameWithoutExtension = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $nameToStore = $nameWithoutExtension . '_' .  $date->timestamp . '.' . $extension;
        $path = $id . '/' . $nameToStore;
        Storage::disk('tmp')->put($path, file_get_contents($file));

        $storedFile = [
            'name' => $nameWithoutExtension,
            'name_to_store' => $nameToStore,
            'path' => $path,
            'url' => Storage::disk('tmp')->url($path),
            'size' => $file->getSize(),
            'thumbnail' => null
        ];

        DB::table('temporary_files')->insert($storedFile);

        return $storedFile;
    }

    public static function delete(string $path): bool
    {
        if (Storage::disk('tmp')->delete($path)) {
            DB::table('temporary_files')
                ->where('name_to_store', $path)
                ->delete();

            return true;
        }
        return false;
    }
}
