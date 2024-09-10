<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\FileTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdatePictureRequest;
use App\Http\Resources\Api\V1\DocumentResource;
use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function getPicture(Request $request): Response
    {
        if ($request->user()->getPicture() == null) {
            return \response([
                'success' => true,
                'picture' => null
            ], 200);
        }

        return \response([
            'success' => true,
            'picture' => new DocumentResource($request->user()->getPicture()),
        ], 200);
    }

    public function updatePicture(UpdatePictureRequest $request): Response
    {
        if ($request->user()->getPicture()) {
            $this->deleteDocument($request->user()->getPicture(), FileTypesEnum::PICTURE->value);
        }

        $this->storeDocument($request, FileTypesEnum::PICTURE->value);

        return \response([
            'success' => true,
        ], 200);
    }

    private function storeDocument(FormRequest $request, string $type): void
    {
        $document = $request->file($type);
        $date = Carbon::now('Europe/Berlin');
        $nameWithoutExtension = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $document->getClientOriginalExtension();
        $nameToStore = $nameWithoutExtension . '_' .  $date->timestamp . '.' . $extension;
        Storage::disk($type)->put($nameToStore, file_get_contents($document));

        Document::query()
            ->create([
                'user_id' => $request->user()->id,
                'name' => $nameWithoutExtension,
                'name_to_store' => $nameToStore,
                'type' => $type,
                'url' => Storage::disk($type)->url($nameToStore),
                'size' => $document->getSize()
            ]);
    }

    public function deletePicture(Request $request): Response
    {
        if ($request->user()->getPicture()) {
            $this->deleteDocument($request->user()->getPicture(), FileTypesEnum::PICTURE->value);
        }

        return \response([
            'success' => true,
        ], 200);
    }

    private function deleteDocument($document, $type)
    {
        if (Storage::disk($type)->delete($document->name_to_store)) {
            Document::destroy($document->id);
        }

        return \response([
            'success' => false,
        ], 500);
    }
}
