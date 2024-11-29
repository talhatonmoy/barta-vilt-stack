<?php 
namespace App\Traits;

use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Likeable{
    // Defining the main relationships with post/comments model open to other model too as it is trait
    // public function likes(): MorphMany
    // {
    //     return $this->MorphMany(Like::class, 'likeable');
    // }

    // public function isLikedByUser($userId)
    // {
    //     return $this->likes()->where('user_id', $userId)->exists();
    // }

    public function likesCount(){
        return $this->likes()->where('is_like', true)->count();
    }

    public function dislikesCount(){
        return $this->likes()->where('is_like', false)->count();
    }
}
