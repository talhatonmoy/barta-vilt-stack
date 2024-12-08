<?php

namespace App\Http\Resources;

use App\Helpers\MediaCollection;
use App\Http\Resources\Friend\FriendRequestResource;
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
            'user_details' => UserDetailsResource::make($this->whenLoaded('user_details')),
            

            // Friend Requests (For People Page)
            'friend_request' => $this->whenLoaded('receivedFriendRequests', function () {
                return FriendRequestResource::make($this->receivedFriendRequests->where('sender_id', auth()->id())->first());
            }),

            // (For People Page)
            'is_friend_request_sent_by_current_user' => $this->whenLoaded('receivedFriendRequests', function () {
                return $this->receivedFriendRequests->contains('sender_id', auth()->id());
            }),

            // For User Page (accepting request)
            'sent_friend_request_data' => $this->whenLoaded('sentFriendRequests', function () {
                if($this->sentFriendRequests->contains('receiver_id', auth()->id())){
                    return FriendRequestResource::make($this->sentFriendRequests->where('receiver_id', auth()->id())->firstOrFail());
                }
            }),

            'is_my_friend' => $this->whenLoaded('friends', function(){
                return $this->friends->contains('user_name', auth()->user()->user_name);
            }),
            // 'allFriends' => $this->whenLoaded('friends')

        ];
    }
}
