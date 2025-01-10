<?php 
namespace App\Services;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Notifications\Post\PostLiked;

class PostLikeService{
    /**
     * Get the like model
     */
    public function getTheLikeModel($post){
        $like = Like::where([
            'user_id' => auth()->id(),
            'likeable_type' => Post::class,
            'likeable_id' => $post->id
        ])->first();

        return $like;
    }

    /**
     * Store new Like
     */

     public function storeNewLike($post){
        $like = Like::create([
            'user_id' => auth()->id(),
            'likeable_type' => Post::class,
            'likeable_id' => $post->id,
            'is_like' => true
        ]);
        return $like;
     }

     /**
      * Notifiy the post author
      */
      public function notifyThePostAuthor($post){
        if ($post->user_id != auth()->id()) {
            $post->load('user.media');
            $post_author = User::find($post->user_id);
            $post_author->notify(new PostLiked($post));
        }
      }

      /**
       * Get the updated post
       */
      public function getTheUpdatedPost($post){
        $post = Post::select(['id', 'uuid', 'user_id', 'excerpt', 'created_at', 'updated_at'])
        ->with(['media', 'user', 'likes.user'])
        ->withCount('comments', 'likes')
            ->find($post->id);

        return $post;
      }
}