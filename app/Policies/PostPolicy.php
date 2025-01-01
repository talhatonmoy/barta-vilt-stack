<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user)
    {
        return true; // everyone can see everyone's posts
    }

    // public function view(User $user, Post $post)
    // {
    //     return $user->id === $post->user_id; // Only the owner can view their post
    // }

    public function create(User $user)
    {
        return $user->id == !null; // Only authenticated can create posts
    }

    public function update(User $user, Post $post)
    {
        // dd($user->id === $post->user_id);
        return $user->id === $post->user_id; // Only the owner can update their post
    }

    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id; // Only the owner can delete their post
    }
}
