<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Helpers\MediaCollection;
use App\Helpers\ReusableHelpers;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            [
                'uuid' => $this->uuid,
                'excerpt' => $this->excerpt,
                'last_modified_time' => ReusableHelpers::getLastModifiedTime($this->created_at, $this->updated_at),
                'remainingPostImages' => $this->getMedia(MediaCollection::PostImage)->count() - 4,
                'postImages' => $this->getMedia(MediaCollection::PostImage)->take(4)->map(function ($eachMedia) {
                    return [
                        'file_name' => $eachMedia->file_name,
                        'url' => $eachMedia->getUrl(),
                    ];
                }),
                'user' => UserResource::make($this->whenLoaded('user')),
            ]
        ];
    }
}
