<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'name' => $this->name,
            'type' => $this->type,
            'url' => $this->url,
            'size' => $this->size,
            'thumbnail' => $this->thumbnail,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
