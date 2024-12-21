<?php

namespace App\Http\Resources\Messenger;

use Illuminate\Http\Request;
use App\Helpers\MediaCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class FriendResourceForMessengerSidebar extends JsonResource
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
            'created_at' => $this->created_at,
            'recentMessagesSentByThisUser' => $this->recentMessagesSentByThisUser->first(),
            'recentMessagesReceivedByThisUser' => $this->recentMessagesReceivedByThisUser,
            'profileImgUrl' => $this->getFirstMediaUrl(MediaCollection::UserProfileImage),
            'latest_message' => MessageResourceForMessengerSidebar::make($this->latestMessage()),
        ];
    }

    // Figuring out latest message
    public function latestMessage()
    {
        $recentMessagesSentByThisUser = $this->recentMessagesSentByThisUser;
        $recentMessagesReceivedByThisUser = $this->recentMessagesReceivedByThisUser;
        // Merge the collection
        $mergedMessages = $recentMessagesSentByThisUser->merge($recentMessagesReceivedByThisUser);
        // Sortby message time
        $sorted =  $mergedMessages->sortByDesc('created_at');

        // return the latest one
        return $sorted->shift();
    }


}
