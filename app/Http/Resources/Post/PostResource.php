<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use App\Helpers\MediaCollection;
use App\Helpers\ReusableHelpers;
use App\Http\Resources\LikeResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\CommentResource;
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
        $mediaItems = $this->getMedia(MediaCollection::PostImage);
        return [
                'uuid' => $this->uuid,
                'post_body' => $this->whenHas('post_body'),
                'excerpt' => $this->whenHas('excerpt'),
                'last_modified_time' => ReusableHelpers::getLastModifiedTime($this->created_at, $this->updated_at),
                
                // Counts
                'comments_count' => $this->whenCounted('comments'),
                'likes_count' => $this->whenCounted('likes'),

                // Is Liked by User
                'is_liked_by_current_user' => $this->whenLoaded('likes', function () {
                    return $this->likes->contains('user_id', auth()->id());
                }),

                //Media
                $this->mergeWhen($this->post_body == null && $mediaItems->count() > 4, [
                    // Only include at collection level using above check
                    'remainingPostImages' => $mediaItems->count() - 4,
                ]),

                'media' => $this->when($mediaItems->count() > 0, function () use ($mediaItems) {
                    // If it is single post page (that means post_body is present and excerpt is absent)
                    if($this->post_body){
                        // Returning all media
                        return PostMediaResource::collection($mediaItems);
                    }
                    // Returning only first 4
                    return PostMediaResource::collection($mediaItems)->take(4);
                }),

                // Related Models
                'user' => UserResource::make($this->whenLoaded('user')),
                'likes' => LikeResource::collection($this->whenLoaded('likes')),
                'comments' => CommentResource::collection($this->whenLoaded('comments'))
        ];
    }
}
