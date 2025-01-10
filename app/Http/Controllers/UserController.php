<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Services\UserService;
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
        // Store 
        $this->userService->store($request);
        // Redirect
        return redirect()->route('user.timeline');
    }

    //Show 
    public function userProfileShow(User $user){

        $userPosts = $this->userService->getUserPosts($user);
        $userProfileData = $this->userService->getUserProfileData($user);

        return Inertia::render('User/UserProfile', [
            'userProfileData' => UserResource::make($userProfileData),
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

    // Handling the loggedin user profile update request
    public function userProfileUpdate(UserUpdateRequest $request){
        // Validation
        $validatedData = $request->validated();
        // Update
        $this->userService->performLoggedInUserProfileUpdate($request, $validatedData);
        // Redirect
        return redirect()->route('user.profile.show', $request->user()->user_name);
    }

    // List All Users - (People Page)
    public function listAllUsers(UserSearchFilterRequest $request){
        $searchData = $request->validated();
        // Getting data
        $allUsers = $this->userService->getAllUsersWithAppliedFilters($searchData);
        $filterableUserDetails = $this->userService->getFiltarableUserDetail();

        return Inertia::render('User/AllUsers', [
            'allUsers' => UserResource::collection($allUsers),
            'filterableUserDetails' => $filterableUserDetails,
        ]);
    }
}
