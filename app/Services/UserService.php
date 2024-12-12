<?php 

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use App\Helpers\MediaCollection;
use App\Helpers\ReusableHelpers;
use App\Http\Resources\UserResource;

class UserService{

    /**
     * Storing new user
     */
    public function store($request){
        $validatedData = $request->validated();
        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'user_name' => $validatedData['user_name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);
        return $user;
    }

    /**
     * Providing authenticated user data
     * Ready for vue component
     */
    public function getAuthenticatedUserData()
    {
        if (auth()->id()) {
            $userData = User::with('media')
                ->withCount('comments', 'posts')
                ->find(auth()->id()); 
            return UserResource::make($userData);
            // return $userData;
        }
        return null;
    }


    /**
     * Providing post collection by username along with user data, 
     * ready to serve in a Vue component.
     * 
     * For User Profile Page
     */
    public function getPostCollectionFrom(object $user){
        $data = [];
        // $user->posts
        $posts = Post::with(['media', 'user']) //Eager Loading
            ->whereHas('user', function ($query) use ($user_name) {
                $query->where('user_name', $user_name);
            })
            ->orderByDesc('created_at')->paginate(10);
            
        $Posts = $this->prepareCollectionDataToShare($posts);
        $data['posts'] = $Posts;
        $data['nextPageUrl'] = $posts->nextPageUrl();
        return $data;
    }

    /**
     * Formatting collection data ready to share in a Vue component.
     * 
     * For User Profile Page
     */
    protected function prepareCollectionDataToShare($postCollection){
        $userPosts = $postCollection->map(function ($post) {
            return [
                'uuid' => $post->uuid,
                'excerpt' => $post->excerpt,
                'last_modified_time' => ReusableHelpers::getLastModifiedTime($post->created_at, $post->updated_at),
                'remainingPostImages' => $post->getMedia(MediaCollection::PostImage)->count() - 4,
                'postImages' => $post->getMedia(MediaCollection::PostImage)->take(4)->map(function($eachMedia){
                    return [
                        'file_name' => $eachMedia->file_name,
                        'url' => $eachMedia->getUrl(),
                    ];
                }),
                'user' => [
                    'first_name' => $post->user->first_name,
                    'last_name' => $post->user->last_name,
                    'user_name' => $post->user->user_name,
                    'bio' => Str::limit($post->user->bio, 220, '...'),
                    'profileImgUrl' => $post->user->getFirstMediaUrl(MediaCollection::UserProfileImage),
                ],
            ];
        });
        return $userPosts;
    }

    
}