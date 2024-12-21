<?php

namespace App\Http\Resources;

use App\Helpers\MediaCollection;
use App\Http\Resources\Friend\FriendRequestResource;
use App\Http\Resources\Messenger\FriendResource;
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
            'email' => $this->whenHas('email'),
            'profileImgUrl' => $this->getFirstMediaUrl(MediaCollection::UserProfileImage),

            // Comments Count
            'comments_count' => $this->whenCounted('comments'),
            
            // Likes Count
            'posts_count' => $this->whenCounted('posts'),

            // Friends Count
            'friends_count' => $this->whenCounted('friends'),

            // Related Models 
            'posts' => PostResourceForUserProfilePage::collection($this->whenLoaded('posts')),
            'user_details' => UserDetailsResource::make($this->whenLoaded('user_details')),

            // (For People Page)
            'is_friend_request_sent_by_current_user' => $this->whenLoaded('receivedFriendRequests', function () {
                return $this->receivedFriendRequests->contains('sender_id', auth()->id());
            }),

            // Applied When Loaded Condition in the method
            'sent_friend_request_data' => $this->getSentFriendRequestDataForLoggedInUser(),
            'received_friend_request_data' => $this->getReceivedFriendRequestDataForLoggedInUser(),
        
            'is_my_friend' => $this->isMyFriend(),

            'friends' => FriendResource::collection($this->whenLoaded('friends'))

        ];
    }

    /**
     * If this user model is my (auth user's) friend or not
     */
    protected function isMyFriend(){
        return $this->whenLoaded('friends', function(){
            return $this->friends->contains('user_name', auth()->user()->user_name);
        });
    }
    
    /**
     * If this user model sent friend request to me (auth user)
     * then this is the record for that
     */
    protected function getSentFriendRequestDataForLoggedInUser() 
    {
        return $this->whenLoaded('sentFriendRequests', function(){
            if ($this->sentFriendRequests->contains('receiver_id', auth()->id())) {
                $friendRequest = $this->sentFriendRequests->where('receiver_id', auth()->id())->firstOrFail();
                return FriendRequestResource::make($friendRequest);
            }
        });
        
    }
    
    /**
     * If this user model received any friend request from me (as loggedin user)
     * then this is the data record for that
     */
    protected function getReceivedFriendRequestDataForLoggedInUser()
    {
        return $this->whenLoaded('receivedFriendRequests', function(){
            if ($this->receivedFriendRequests->contains('sender_id', auth()->id())) {
                $friendRequest = $this->receivedFriendRequests->where('sender_id', auth()->id())->firstOrFail();
                return FriendRequestResource::make($friendRequest);
            }
        });
        
    }
}
