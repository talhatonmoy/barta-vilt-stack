<?php

namespace App\Http\Controllers;

use App\Events\NewMessageCreated;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Resources\Messenger\FriendResourceForMessengerSidebar;
use App\Http\Resources\Messenger\MessageResource;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Message;
use App\Http\Resources\UserResource;
use App\Models\Friendship;

class MessageController extends Controller
{
    // For Messenger UI
    public function messenger(){
        $friendsWithLastConversationMessage = request()->user()->load([
            'friends.recentMessagesSentByThisUser',
            'friends.recentMessagesReceivedByThisUser'
        ])->friends;

        return Inertia::render('Messenger/Messenger', [
            'friendsWithLastConversationMessage' => FriendResourceForMessengerSidebar::collection($friendsWithLastConversationMessage)
        ]);
    }
    

    // For individual User Message UI
    public function indexMessage(User $user){
        $friend = $user;

        $friendsWithLastConversationMessage = request()->user()->load([
            'friends.recentMessagesSentByThisUser',
            'friends.recentMessagesReceivedByThisUser'
        ])->friends;

        return Inertia::render('Messenger/Index', [
            'friendData' => UserResource::make($friend),
            'friendsWithLastConversationMessage' => FriendResourceForMessengerSidebar::collection($friendsWithLastConversationMessage)
        ]);
    }

    public function loadMessage(User $user){
        $friend = $user;

        $messages = Message::whereIn('sender_id', [auth()->id(), $friend->id])
        ->whereIn('receiver_id', [auth()->id(), $friend->id])
        ->orderByDesc('created_at')
        ->paginate(25);
        
        return MessageResource::collection($messages);
    }

    public function storeMessage(MessageStoreRequest $request,User $user){
        $validatedData = $request->validated();

        $friend = $user;
        $friend->recentMessagesSentByThisUser()->update([
            'read_at' => now()
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $friend->id,
            'body' => $validatedData['body'],
        ]);

       

        // BroadCasting Message
        broadcast(new NewMessageCreated($message));

        return MessageResource::make($message);
    }
}
