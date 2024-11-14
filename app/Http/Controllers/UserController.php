<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Services\UserService;
use App\Helpers\MediaCollection;
use App\Helpers\ReusableHelpers;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    // Create
    public function userCreate(){
        return Inertia::render('User/UserRegistration');
    }

    // Store
    public function userStore(UserStoreRequest $request){
        //-Check Authorization
        $this->userService->store($request);
        return redirect()->route('user.timeline');
    }

    //Show 
    public function userProfileShow($user_name){
        $userPostsData = $this->userService->getPostCollectionFrom($user_name);
        return Inertia::render('User/UserProfile', [
            'userPosts' => $userPostsData['posts'],
            'nextPageUrl' => $userPostsData['nextPageUrl'],
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
}
