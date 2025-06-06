<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FriendRequests extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'status'];

    public function friendships(){
        return $this->hasMany(Friendship::class);
    }
}
