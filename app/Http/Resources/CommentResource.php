<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Helpers\MediaCollection;
use App\Helpers\ReusableHelpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Can;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'post_uuid' => $this->post_uuid,
            'comment_body' => $this->comment_body,
            'last_modified_time' => ReusableHelpers::getLastModifiedTime($this->created_at, $this->updated_at),
            'user' => UserResource::make($this->whenLoaded('user')),
            'can' => [
                'update' => $request->user()->can('update', $this->resource),
                'delete' => $request->user()->can('delete', $this->resource),
            ]
        ];
    }
}
