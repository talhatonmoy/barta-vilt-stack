<?php

namespace App\Http\Resources;

use App\Helpers\MediaCollection;
use App\Http\Resources\Post\PostResourceForUserProfilePage;
use App\Http\Resources\User\UserDetailsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'user_name' => $this->user_name,
            'bio' => $this->bio,
            'profileImgUrl' => $this->getFirstMediaUrl(MediaCollection::UserProfileImage),

            // Comments Count
            'comments_count' => $this->whenCounted('comments'),
            
            // Likes Count
            'posts_count' => $this->whenCounted('posts'),

            // Related Models 
            'posts' => PostResourceForUserProfilePage::collection($this->whenLoaded('posts')),
            'user_details' => UserDetailsResource::make($this->whenLoaded('user_details'))
        ];
    }
}
