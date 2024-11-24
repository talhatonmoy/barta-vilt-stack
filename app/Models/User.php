<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Post;
use App\Helpers\MediaCollection;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'user_name',
        'bio',
        'email',
        'password',
        'profileImg'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relation with user_details table
    public function user_details(){
        return $this->hasOne(UserDetail::class)->latest();
    }
    
    // Relation with posts table
    public function posts(){
        return $this->hasMany(Post::class)->with(['media', 'user']);
    }

    // Relation with comments table
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Defining to hold single file
    public function registerMediaCollections(): void
    {
        // Single user profile image
        $this->addMediaCollection(MediaCollection::UserProfileImage)
            ->useFallbackUrl('/img/placeholders/profile.jpg')
            ->singleFile();
    }
}
