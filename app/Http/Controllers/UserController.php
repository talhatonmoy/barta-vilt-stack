<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\UserDetail;
use Illuminate\Support\Str;
use App\Services\UserService;
use App\Helpers\MediaCollection;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\PostCardComponentService;
use App\Http\Requests\UserSearchFilterRequest;
use App\Http\Resources\Post\PostResourceForUserProfilePage;

class UserController extends Controller
{
    public $userService, $postCardComponentService;
    public function __construct(UserService $userService, PostCardComponentService $postCardComponentService)
    {
        $this->userService = $userService;
        $this->postCardComponentService = $postCardComponentService;
    }

    // Create
    public function userCreate(){
        return Inertia::render('User/UserRegistration');
    }

    // Store
    public function userStore(UserStoreRequest $request){
        $user = $this->userService->store($request);

        // event(new NewUserRegistered($user));
        
        return redirect()->route('user.timeline');

    }

    //Show 
    public function userProfileShow(User $user){

        $userPosts = $user->posts()->paginate(10);
        $user->loadCount(['comments', 'posts', 'friends']);
        $user->load(['sentFriendRequests', 'receivedFriendRequests']);

        return Inertia::render('User/UserProfile', [
            'userData' => UserResource::make($user),
            'userPosts' => PostResourceForUserProfilePage::collection($userPosts),
        ]);
    }

    // Edit User 
    public function userProfileEdit(){
        $userData = $this->userService->getAuthenticatedUserData();
        return Inertia::render('User/UserProfileEdit', [
            'userData' => $userData
        ]);
    }

    // Handling the update request
    public function userProfileUpdate(UserUpdateRequest $request){
        $validatedData = $request->validated();
        $user = User::find(auth()->id());
        $user->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'bio' => Str::limit($validatedData['bio'], 220, '...')
        ]);
        if($request->hasFile('profileImg')){
            $user->addMedia($request->file('profileImg'))->toMediaCollection(MediaCollection::UserProfileImage);
        }
        return redirect()->route('user.profile.show', $user->user_name);
    }

    // List All Users
    public function listAllUsers(UserSearchFilterRequest $request){
        $searchData = $request->validated();
        $allUsers = User::with(['media', 'receivedFriendRequests', 'friends', 'sentFriendRequests'])
                        ->when($searchData['searchTerm'] ?? false, function($query) use ($searchData){
                            return $query->whereAny([
                                'first_name',
                                'last_name'
                            ], 'LIKE', "%" . $searchData['searchTerm']. "%");
                        })
                        ->when($searchData['search'] ?? false, function ($query) use ($searchData) {
                            return $query->whereAny([
                                'first_name',
                                'last_name'
                            ], 'LIKE', "%" . $searchData['search'] . "%");
                        })
                        ->when($searchData['city'] ?? false, function($query) use ($searchData){
                            // Checking at (hasOne - user_details related table)
                            return $query->whereHas('user_details', function($query) use ($searchData){
                                 $query->where('current_city' , $searchData['city']);
                            });
                        })
                        ->when($searchData['gender'] ?? false, function ($query) use ($searchData) {
                            // Checking at (hasOne - user_details related table)
                            return $query->whereHas('user_details', function($query) use ($searchData){
                                $query->where('gender', $searchData['gender']);
                            });
                        })
                        ->when($searchData['primaryLang'] ?? false, function ($query) use ($searchData) {
                            // Checking at (hasOne - user_details related table)
                            return $query->whereHas('user_details', function($query) use ($searchData){
                                $query->where('primary_lang', $searchData['primaryLang']);
                            });
                        })
                        ->where('id', '!=' , auth()->id())
                        ->paginate(12)
                        ->withQueryString();
// dd($allUsers);

        $filterableUserDetails = [];
        $filterableUserDetails['uniqueCities'] = UserDetail::whereNotNull('current_city')->distinct()->pluck('current_city');
        $filterableUserDetails['primaryLang'] = UserDetail::whereNotNull('primary_lang')->distinct()->pluck('primary_lang');

        return Inertia::render('User/AllUsers', [
            'allUsers' => UserResource::collection($allUsers),
            'filterableUserDetails' => $filterableUserDetails,
        ]);
    }
}
