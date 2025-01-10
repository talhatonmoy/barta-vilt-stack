<?php 

namespace App\Services;

use App\Models\Message;

class MessageService{

    /**
     * Providing friend list with last conversation 
     * message with loggedin user
     */
    public function friendListWithLastConversationMessage(){
        return request()->user()->load([
            'friends.recentMessagesSentByThisUser',
            'friends.recentMessagesReceivedByThisUser'
        ])->friends;
    }

    /**
     * Providing conversations between Friend and Loggedin user
     */
    public function getConversationWith($friend){
        $messages = Message::whereIn('sender_id', [auth()->id(), $friend->id])
            ->whereIn('receiver_id', [auth()->id(), $friend->id])
            ->orderByDesc('created_at')
            ->paginate(25);

        return $messages;
    }


    /**
     * Store Message
     */
    public function storeMessage($friend, $validatedData){

        $friend->recentMessagesSentByThisUser()->update([
            'read_at' => now()
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $friend->id,
            'body' => $validatedData['body'],
        ]);

        return $message;
    }

}