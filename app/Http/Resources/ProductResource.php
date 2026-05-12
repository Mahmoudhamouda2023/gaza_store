<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $mainImage = $this->images->where('type', 'main')->first();

        $galleryImages = $this->images->where('type', 'gallery');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,

            'image' => $mainImage
                ? asset('images/' . $mainImage->path)
                : null,

            'gallery' => ImageResource::collection($galleryImages),

            'category' => new CategoryResource($this->category),
        ];
    }
}
