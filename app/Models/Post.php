<?php

namespace App\Models;

use App\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'uuid',
        'user_id',
        'post_body',
        'excerpt'
    ];

    // Relationship with user
    public function user(){
        return $this->belongsTo(User::class);
    }

    // Relationship with comments
    public function comments(){
        return $this->hasMany(Comment::class );
    }

    // Relation with likes
    public function likes(): MorphMany
    {
        return $this->MorphMany(Like::class, 'likeable');
    }


}
