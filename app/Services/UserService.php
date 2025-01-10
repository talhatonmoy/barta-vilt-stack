<?php 

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Str;
use App\Helpers\MediaCollection;
use App\Helpers\ReusableHelpers;
use App\Http\Resources\UserResource;
use PhpParser\Node\Expr\Cast\Object_;

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
     * Get user posts
     */
    public function getUserPosts(Object $userObject, Int $paginate = 10){
        return $userObject->posts()->paginate($paginate);
    }

    /**
     * Get user profile data
     */
    public function getUserProfileData(Object $userObject){
        $userObject->loadCount(['comments', 'posts', 'friends']);
        $userObject->load(['sentFriendRequests', 'receivedFriendRequests']);

        return $userObject;
    }

    /**
     * Perform loggedin user profile update
     */
    public function performLoggedInUserProfileUpdate($request, $validatedData){
        $user = $request->user();

        $user->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'bio' => Str::limit($validatedData['bio'], 220, '...')
        ]);

        if ($request->hasFile('profileImg')) {
            $user->addMedia($request->file('profileImg'))->toMediaCollection(MediaCollection::UserProfileImage);
        }
    }

    /**
     * Providing all users with search query and filters
     * Along with default pagination = 12
     */
    public function getAllUsersWithAppliedFilters($searchData, Int $paginate = 12){
        $allUsers = User::with(['media', 'receivedFriendRequests', 'friends', 'sentFriendRequests'])
            ->when($searchData['searchTerm'] ?? false, function ($query) use ($searchData) {
                return $query->whereAny([
                    'first_name',
                    'last_name'
                ], 'LIKE', "%" . $searchData['searchTerm'] . "%");
            })
            ->when($searchData['search'] ?? false, function ($query) use ($searchData) {
                return $query->whereAny([
                    'first_name',
                    'last_name'
                ], 'LIKE', "%" . $searchData['search'] . "%");
            })
            ->when($searchData['city'] ?? false, function ($query) use ($searchData) {
                // Checking at (hasOne - user_details related table)
                return $query->whereHas('user_details', function ($query) use ($searchData) {
                    $query->where('current_city', $searchData['city']);
                });
            })
            ->when($searchData['gender'] ?? false, function ($query) use ($searchData) {
                // Checking at (hasOne - user_details related table)
                return $query->whereHas('user_details', function ($query) use ($searchData) {
                    $query->where('gender', $searchData['gender']);
                });
            })
            ->when($searchData['primaryLang'] ?? false, function ($query) use ($searchData) {
                // Checking at (hasOne - user_details related table)
                return $query->whereHas('user_details', function ($query) use ($searchData) {
                    $query->where('primary_lang', $searchData['primaryLang']);
                });
            })
            ->where('id', '!=', auth()->id())
            ->paginate($paginate)
            ->withQueryString();

        return $allUsers;
    }

    /**
     * Providing filterable user detail 
     * for people page sidebar filter
     */
    public function getFiltarableUserDetail(){
        $filterableUserDetails = [];
        $filterableUserDetails['uniqueCities'] = UserDetail::whereNotNull('current_city')->distinct()->pluck('current_city');
        $filterableUserDetails['primaryLang'] = UserDetail::whereNotNull('primary_lang')->distinct()->pluck('primary_lang');

        return $filterableUserDetails;
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