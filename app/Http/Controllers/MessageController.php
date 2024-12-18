<?php

namespace App\Http\Controllers;

use App\Events\NewMessageCreated;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Resources\Messenger\FriendResource;
use App\Http\Resources\Messenger\FriendResourceForMessengerSidebar;
use App\Http\Resources\Messenger\MessageResource;
use App\Http\Resources\Messenger\UserResourceForMessengerSidebar;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

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

    public function storeMessage( MessageStoreRequest $request,User $user){
        $receiver = $user;
        $validatedData = $request->validated();
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiver->id,
            'body' => $validatedData['body'],
        ]);

        // BroadCasting Message
        broadcast(new NewMessageCreated($message));

        return MessageResource::make($message);
    }
}
