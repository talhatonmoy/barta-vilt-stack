<?php

namespace App\Http\Controllers;

use App\Events\NewUserRegistered;
use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Services\UserService;
use App\Helpers\MediaCollection;
use App\Helpers\ReusableHelpers;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\Post\PostResourceForUserProfilePage;
use App\Http\Resources\UserResource;
use App\Services\PostCardComponentService;

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
        $user->loadCount(['comments', 'posts']);
        $user->load(['sentFriendRequests', 'friends', 'receivedFriendRequests']);

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
    public function listAllUsers(){
        $allUsers = User::with(['media', 'receivedFriendRequests', 'friends', 'sentFriendRequests'])
                        ->where('id', '!=' , auth()->id())
                        ->paginate(12);
        return Inertia::render('User/AllUsers', [
            'allUsers' => UserResource::collection($allUsers)
        ]);
    }
}
