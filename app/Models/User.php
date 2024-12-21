<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Post;
use App\Helpers\MediaCollection;
use Carbon\Carbon;
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
        // return $this->hasMany(Post::class)->with(['media', 'user']);
        return $this->hasMany(Post::class)
                    ->select(['id', 'uuid', 'user_id', 'excerpt', 'created_at', 'updated_at'])
                    ->withCount('comments', 'likes')
                    ->with(['user', 'media', 'comments.user', 'likes.user']);
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

    /**
     * Relationships related to friends
     */
    
     //Friend requests a user has sent so far - SELECT * FROM friend_requests WHERE sender_id = 1;
     public function sentFriendRequests(){
        return $this->hasMany(FriendRequests::class, 'sender_id');
     }

    //Friend requests a user has received so far - SELECT * FROM friend_requests WHERE receiver_id = 1;
    public function receivedFriendRequests()
    {
        return $this->hasMany(FriendRequests::class, 'receiver_id');
    }

    /**
     * This method retrieves all users who are friends with the current user
     * friendsOf: This method retrieves all users who are friends of the current user. 
     * In other words, it finds users that consider the current user as their friend.
     */
    public function friendsOf(){
        return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id');
    }

    /**
     * This method retrieves all users that - the current user has as friends.
     * This method retrieves all users that the current user considers as friends. 
     * Essentially, it looks for users that the current user has sent friend requests to and have accepted them.
     */
    public function friends(){
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id');
    }

    // All friends
    public function allFriends() {
        return $this->friends->merge($this->friendsOf());
    }

    // Mutual friends
    public function mutualFriends(User $otherUser){
        $loggedinUserFriendIds  = $this->allFriends()->pluck('id')->toArray();
        $otherUserFriendIds = $otherUser->allFriends()->pluck('id')->toArray();

        $mutualFriendIds = array_intersect($loggedinUserFriendIds, $otherUserFriendIds);
        return User::whereIn('id', $mutualFriendIds)->get();
    }
    
    /**
     * Messages
     */
    public function messagesSentByThisUser(){
        return $this->hasMany(Message::class, 'sender_id');
    }

    // This will return all messages where the receiver_id matches the ID of $user. 
    public function messagesReceivedByThisUser()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }


    // Recent

    public function recentMessagesSentByThisUser()
    {
        return $this->hasMany(Message::class, 'sender_id')
        ->where('receiver_id', auth()->id())
        ->latest()->take(1);
    }
    public function recentMessagesReceivedByThisUser()
    {
        return $this->hasMany(Message::class, 'receiver_id')
            ->where('receiver_id', auth()->id())
            ->latest()->take(1);
    }
}
