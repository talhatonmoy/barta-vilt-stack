<?php

namespace App\Http\Controllers\Friend;

use App\Models\User;
use App\Models\FriendRequests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\Friend\FriendRequestSent;

class FriendRequestController extends Controller
{
    public function toggleFriendRequest(User $user, bool $is_api = false){
        $receiver = $user;

        $existingRequest = FriendRequests::where('sender_id', auth()->id())
                                        ->where('receiver_id', $receiver->id)
                                        ->first();

        if($existingRequest){
            $existingRequest->delete();
            // Sending response if it is axios call
            if ($is_api == true)  return response()->json(['status' => 'add friend']);
        }else{
            $friendRequest = FriendRequests::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $receiver->id,
                'status' => 'pending'
            ]);
            // Notify Receiver
            $receiver->notify(new FriendRequestSent());

            // Sending response if it is axios call
            if ($is_api == true) return response()->json(['status' => $friendRequest->status]);
        }
    }

    public function acceptFriendRequest(FriendRequests $friend_requests){
       $friendRequestData = $friend_requests;

       // Authorizing
       if($friendRequestData->receiver_id !== auth()->id()){
            return;
       }

       $friendRequestData->update(['status' => 'accepted']);

       // Create Record for friendship table for both users (sender and receiver)
       DB::transaction(function() use($friendRequestData){
            // For Sender
            $friendRequestData->friendships()->create([
                'user_id' => $friendRequestData->sender_id,
                'friend_id' => $friendRequestData->receiver_id
            ]);

            // For Receiver
            $friendRequestData->friendships()->create([
                'user_id' => $friendRequestData->receiver_id,
                'friend_id' => $friendRequestData->sender_id
            ]);
       });
    }


    public function rejectFriendRequest(FriendRequests $friendRequests){
        $friendRequestData = $friendRequests; // Just to assign a valid name

        // Authorizing
        if($friendRequestData->receiver_id != auth()->id()){
            return;
        }

        $friendRequestData->delete();
        return back();
    }

    public function unfriend(FriendRequests $friendRequests){  
        $friendRequests->delete();
        return back();
    }
}
