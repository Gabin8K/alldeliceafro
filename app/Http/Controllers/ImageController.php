<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    /**
     * @throws BindingResolutionException
     */
    public function show(Request $request)
    {
        $image = Image::query()->where('id', $request->id)->first();

//        $filePath = public_path() . '/images/products/514/Online-Digi-dbdiagram-io_1710770993.png';
        $filePath = Storage::disk($request->disk)->path($image->path);
        $fileContent = File::get($filePath);

        $mimeType = File::mimeType($filePath);

        return response()->make($fileContent, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $image->name_to_store . '"',
        ]);
//        return response()->download(public_path() . '/images/products/514/Online-Digi-dbdiagram-io_1710770993.png'); 'inline; filename="' . $image . '"'
    }

    public function delete(Request $request): void
    {
        Image::destroy($request->id);
    }
}
