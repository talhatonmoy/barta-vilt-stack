<?php 

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Str;
use App\Helpers\MediaCollection;
use App\Helpers\ReusableHelpers;

class PostService{

    /**
     * Providing ready-to-share post details along 
     * with related user data for the Vue component.
     */
    public function getPostDetailWithAllData(object $post){
        $post->load(['user.media', 'likes.user', 'comments.user']);
        $post->loadCount('comments', 'likes');
        return $post;
    }

    /**
     * Providing post instance from post uuid
     */
    public function getThePostInstanceFrom($uuid){
        return Post::where('uuid', $uuid)->firstOrFail();
    }


}