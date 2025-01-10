<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Resources\Post\PostResource;
use App\Services\PostLikeService;

class PostLikeController extends Controller
{
    public function __construct(protected PostLikeService $postLikeService)
    {
        
    }

    public function toggleLike(Post $post)
    {
        // Get the like instance
        $like = $this->postLikeService->getTheLikeModel($post);

        if($like){
            // Delete the model
            $like->delete();
        }else{
            // Store new model
            $like = $this->postLikeService->storeNewLike($post);
            
            // Notify Post Author
            $this->postLikeService->notifyThePostAuthor($post);
        }
        
        // Returning updated post
        $updatedPost = $this->postLikeService->getTheUpdatedPost($post);
        return new PostResource($updatedPost);
    }

}
