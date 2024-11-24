<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
        return $this->belongsTo(User::class)->with('media');
    }

    // Relationship with comments
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    //
    // public function postMedia(){
    //     return $this->morphMany($this->getMediaModel(), 'model');
    // }

}
