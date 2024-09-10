<?php

namespace App\Http\Controllers;

use App\Services\TemporaryFileService;
use Illuminate\Http\Request;

class TemporaryFileController extends Controller
{
    public function store(Request $request): string
    {
        if ($request->hasFile('image')) {
            $storedFile = TemporaryFileService::store(
                file: $request->file('image')
            );

            return $storedFile['name_to_store'];
        }

        return '';
    }

    public function delete(Request $request): string
    {
        TemporaryFileService::delete(
            path: $request->uniqueId
        );

        return '';
    }
}
