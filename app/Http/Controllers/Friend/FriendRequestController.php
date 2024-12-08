<?php

namespace App\Http\Controllers\Friend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\FriendRequests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Friendship;
use App\Notifications\Friend\FriendRequestSent;

class FriendRequestController extends Controller
{
    public function toggleFriendRequest(User $user){
        $receiver = $user;

        $existingRequest = FriendRequests::where('sender_id', auth()->id())
                                        ->where('receiver_id', $receiver->id)
                                        ->first();

        if($existingRequest){
            $existingRequest->delete();
        }else{
            FriendRequests::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $receiver->id,
                'status' => 'pending'
            ]);
            // Notify Receiver
            $receiver->notify(new FriendRequestSent());
        }
    }

    public function acceptFriendRequest(FriendRequests $friend_requests){
       $friendRequestData = $friend_requests;
       // Authorizing
       if($friendRequestData->receiver_id != auth()->id()){
        return;
       }

       $friendRequestData->update(['status' => 'accepted']);

       // Create Record for friendship table for both users (sender and receiver)
       DB::transaction(function() use($friendRequestData){
            // For Sender
            Friendship::create([
                'user_id' => $friendRequestData->sender_id,
                'friend_id' => $friendRequestData->receiver_id
            ]);

            // For Receiver
            Friendship::create([
                'user_id' => $friendRequestData->receiver_id,
                'friend_id' => $friendRequestData->sender_id
            ]);
       });
    }
}
