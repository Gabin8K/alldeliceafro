<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductRessource extends JsonResource
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
            'restaurant_id' => $this->restaurant_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'images' => DocumentResource::collection($this->whenLoaded('images')),
            'restaurant' => new RestaurantRessource($this->whenLoaded('restaurant')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
