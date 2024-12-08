<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Events\TestEvent;
use App\Http\Resources\Post\PostResource;
use Illuminate\Http\Request;
use App\Notifications\Post\PostLiked;
use Illuminate\Support\Facades\Notification;

class PostLikeController extends Controller
{

    public function toggleLike(Post $post)
    {
        $like = Like::where([
                    'user_id' => auth()->id(),
                    'likeable_type' => Post::class,
                    'likeable_id' => $post->id
                ])->first();

        if($like){
            $like->delete();
        }else{
            $like = Like::create([
                'user_id' => auth()->id(),
                'likeable_type' => Post::class,
                'likeable_id' => $post->id,
                'is_like' => true
            ]);
            
            // Notify Post Author
            if($post->user_id != auth()->id()){
                $post->load('user.media');
                $post_author = User::find($post->user_id);
                $post_author->notify(new PostLiked($post));
                // broadcast(new TestEvent($post_author));
            }
            
        }
        
        $updatedPost = Post::select(['id', 'uuid', 'user_id', 'excerpt', 'created_at', 'updated_at'])
        ->with(['media', 'user', 'likes.user'])
        ->withCount('comments', 'likes')
            ->find($post->id);
            
        return new PostResource($updatedPost);
    }

    public function toggleDislike(Post $post)
    {
        $like = Like::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'likeable_id' => $post->id,
                'likeable_type' => Post::class,
            ],
            ['is_like' => false]
        );

        return back();
    }
}
