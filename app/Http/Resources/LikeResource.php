<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        // $likeable = $this->likeable; // This assumes a polymorphic relationship

        return [
            'id' => $this->id,
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
