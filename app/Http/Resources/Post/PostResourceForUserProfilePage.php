<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use App\Helpers\MediaCollection;
use App\Helpers\ReusableHelpers;
use App\Http\Resources\LikeResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResourceForUserProfilePage extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $mediaItems = $this->getMedia(MediaCollection::PostImage);
        return [
                'uuid' => $this->uuid,
                'post_body' => $this->whenHas('post_body'),
                'excerpt' => $this->whenHas('excerpt'),
                'last_modified_time' => ReusableHelpers::getLastModifiedTime($this->created_at, $this->updated_at),
                
                // Comments Count
                'comments_count' => $this->whenCounted('comments'),

                // Likes Count
                'likes_count' => $this->whenCounted('likes'),

                // Is Liked by User
                'is_liked_by_current_user' => $this->whenLoaded('likes', function () {
                    return $this->likes->contains('user_id', auth()->id());
                }),

                //Media
                $this->mergeWhen($mediaItems->count() > 4 , [
                    'remainingPostImages' => $mediaItems->count() - 4,
                ]),

                'media' => $this->when($mediaItems->count() > 0, function () use ($mediaItems) {
                    return PostMediaResource::collection($mediaItems)->take(4);
                }),

                // Related Models
                'user' => UserResource::make($this->whenLoaded('user')),
                'likes' => LikeResource::collection($this->whenLoaded('likes')),
                'comments' => CommentResource::collection($this->whenLoaded('comments'))
        ];
    }
}
