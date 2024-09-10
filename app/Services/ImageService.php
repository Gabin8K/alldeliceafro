<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public static function store(array $temporary_images, string $disk, string $foreign_key, string $foreign_key_value): void
    {
        $temporary_images = DB::table('temporary_files')->whereIn('name_to_store', $temporary_images)->get();

        foreach ($temporary_images as $image) {

            $path = $foreign_key_value . '/' . $image->name_to_store;
            $copy_successful = Storage::disk($disk)
                ->writeStream(
                    path: $path,
                    resource: Storage::disk('tmp')->readStream($image->name_to_store)
                );

            if ($copy_successful) {
                Image::query()
                    ->create([
                        $foreign_key => $foreign_key_value,
                        'name_to_store' => $image->name_to_store,
                        'name' => $image->name,
                        'path' => $path,
                        'url' => Storage::disk($disk)->url($path),
                        'size' => $image->size,
                        'thumbnail' => $image->thumbnail,
                    ]);
            }

            TemporaryFileService::delete($image->name_to_store);
        }
    }

    public static function delete($images, string $disk): void
    {
        foreach ($images as $image) {
            if (Storage::disk($disk)->delete($image->path)) {
                Image::destroy($image->id);
            }
        }
    }
}
