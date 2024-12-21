<?php

namespace App\Http\Resources\Messenger;

use Illuminate\Http\Request;
use App\Helpers\MediaCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class FriendResource extends JsonResource
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
            'profileImgUrl' => $this->getFirstMediaUrl(MediaCollection::UserProfileImage),
            $this->mergeWhen($this->whenLoaded('recentMessagesSentByThisUser') && $this->whenLoaded('recentMessagesReceivedByThisUser'),[
                'latestMessage' => $this->latestMessage()
            ]),
        ];
    }

    public function latestMessage(){
        $recentMessagesSentByThisUser = $this->recentMessagesSentByThisUser;
        $recentMessagesReceivedByThisUser = $this->recentMessagesReceivedByThisUser;
        $mergedMessages = $recentMessagesSentByThisUser->merge($recentMessagesReceivedByThisUser);

        $sorted =  $mergedMessages->sortByDesc('created_at');

        return $sorted;
    }
}
