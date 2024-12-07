<?php 
namespace App\Services;

use App\Models\Like;
use App\Models\Post;

class PostCardComponentService{

    /**
     * Timeline Posts (All Users)
     * Providing latest post collections with associated user data
     */
    public function getLatestPostCollectionFromAllUsers()
    {
        $posts = Post::select(['id', 'uuid', 'user_id', 'excerpt', 'created_at', 'updated_at'])
        ->with([ 'media', 'user.media', 'likes.user'])
        ->withCount('comments', 'likes')
        ->latest()->paginate(10);

        return $posts;
    }


    public function getUserDataWithDetails(){
        return auth()->user()->load(['user_details', 'media']);
    }
}