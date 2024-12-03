<?php

namespace App\Notifications\Post;

use App\Http\Resources\UserResource;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PostLiked extends Notification
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
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $authUser = auth()->user();
        return [
            'post_link' => route('posts.show', $this->post->uuid),
            'message' => 'Liked your post',
            'sender' => UserResource::make($authUser),
        ];
    }
}
