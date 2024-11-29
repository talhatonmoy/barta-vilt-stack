<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

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
            Like::create([
                'user_id' => auth()->id(),
                'likeable_type' => Post::class,
                'likeable_id' => $post->id,
                'is_like' => true
            ]);
            // Fire PostLiked event
        }
        return back();
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
