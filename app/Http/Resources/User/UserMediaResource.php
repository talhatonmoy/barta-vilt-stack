<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use App\Helpers\MediaCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->resource);

        return [
            'id' => $this->id,
            'original_url' => $this->original_url,
            'file_name' => $this->file_name
        ];
    }
}
