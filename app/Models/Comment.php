<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
            'uuid',
            'post_id',
            'user_id',
            'comment_body' ,
            'excerpt',
            'post_uuid' ,
    ];

    // Relationship with post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
