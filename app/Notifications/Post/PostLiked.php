<?php

namespace App\Notifications\Post;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use App\Http\Resources\UserResource;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class PostLiked extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Post $post)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'post_link' => route('posts.show', $this->post->uuid),
            'message' => 'Liked your post',
            'excerpt' => Str::limit($this->post->excerpt, 60, '...'),
            'type' => 'postLike',
            'sender' => UserResource::make(auth()->user()),
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'post_link' => route('posts.show', $this->post->uuid),
            'message' => 'Liked your post',
            'sender' => UserResource::make(auth()->user()),
        ]);
    }

    
}
