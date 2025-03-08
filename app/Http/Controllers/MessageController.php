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
use App\Services\CommentService;
use App\Services\MessageService;

class MessageController extends Controller
{
    protected $messageService;
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }


    // For Messenger UI
    public function messenger(){
        $friendList = $this->messageService->friendListWithLastConversationMessage();

        return Inertia::render('Messenger/Messenger', [
            'friendListWithLatestMessage' => FriendResourceForMessengerSidebar::collection($friendList)
        ]);
    }
    

    // For individual User Message UI
    public function indexMessage(User $user){
        $friend = $user;

        $friendListWithLastMessage = $this->messageService->friendListWithLastConversationMessage();

        return Inertia::render('Messenger/Index', [
            'friendData' => UserResource::make($friend),
            'friendListWithLastMessage' => FriendResourceForMessengerSidebar::collection($friendListWithLastMessage)
        ]);
    }

    public function loadMessage(User $user){
        $friend = $user; // Pointing friend
    
        $messages = $this->messageService->getConversationWith($friend);
        
        return MessageResource::collection($messages);
    }

    public function storeMessage(MessageStoreRequest $request,User $user){
        $friend = $user;

        // Validation
        $validatedData = $request->validated();

        // Store
        $message = $this->messageService->storeMessage($friend, $validatedData);
        
    
        // BroadCasting Message
        broadcast(new NewMessageCreated($message));

        // Return response
        return MessageResource::make($message);
    }
}
