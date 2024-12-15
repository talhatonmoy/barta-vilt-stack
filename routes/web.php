<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\BartaMediaController;
use App\Http\Controllers\UserDetailController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Friend\FriendRequestController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Notification\NotificationController;

/**
 * Open routes
 */
Route::get('/', function () {
    return redirect()->route('user.login.create');
});

Route::get('/test', function () {
    return Inertia::render('Test');
});

/**
 * Guest routes
 */
Route::middleware('guest')->group(function(){
    // View registration page
    Route::get('/registration', [UserController::class, 'userCreate'])->name('user.create');
    // Handling reg store request
    Route::post('/registration', [UserController::class, 'userStore'])->name('user.store');

    // Login page
    Route::get('/login', [UserAuthController::class, 'login'])->name('user.login.create');
    // Handling authenticate request
    Route::post('/login', [UserAuthController::class, 'authenticate'])->name('user.login.store');
});



/**
 * Protected routes
 */
Route::middleware('auth')->group(function(){
    // Timeline
    Route::get('/timeline', [TimelineController::class, 'timelinePage'])->name('user.timeline');
    
    // User Profile 
    Route::get('/user/{user:user_name}', [UserController::class, 'userProfileShow'])->name('user.profile.show');
    // Edit Profile 
    Route::get('/user/profile/edit', [UserController::class, 'userProfileEdit'])->name('user.profile.edit');
    // Handle User Profile Update
    Route::post('/user/profile/edit', [UserController::class, 'userProfileUpdate'])->name('user.profile.update');
    
    //People - List Users
    Route::get('/users', [UserController::class, 'listAllUsers'])->name('users.list');

    // User Detail Store
    Route::post('user/profile/detail', [UserDetailController::class, 'userDetailStore'])->name('user.detail.store');
    // User Detail Edit
    Route::get('user/profile/detail', [UserDetailController::class, 'userDetailEdit'])->name('user.detail.edit');
    // Handle User Detail update
    Route::patch('user/profile/detail', [UserDetailController::class, 'userDetailUpdate'])->name('user.detail.update');


    // Post Routes
    Route::resource('posts', PostController::class)->except(['index', 'create']);


    //Likes
    Route::post('/posts/{post:uuid}/like', [PostLikeController::class, 'toggleLike'])->name('posts.like');


    // Comments
    Route::resource('comments', CommentController::class);

    // Messenger
    Route::get('/messenger', [MessageController::class, 'indexMessage'])->name('message.index');


    // User Notifications
    Route::get('/notifications', [NotificationController::class, 'allNotifications'])->name('user.notifications');
    
    // Notifications Tray (for returning unread notifications only)
    Route::get('/notifications/tray', [NotificationController::class, 'notificationTray'])->name('user.notifications.tray');

    // Notifications Mark All As Read
    Route::post('/notifications/mark_all_as_read', [NotificationController::class, 'markAllAsRead'])->name('user.notifications.mark_all_as_read');

    /**
     * Routes related to friends
     */
    // Friend request sent
    // Route::post('friend-requests/{user:user_name}', [FriendRequestController::class, 'toggleFriendRequest'])->name('friend.request.toggle');
    Route::post('friend-requests/{user:user_name}/api/{is_api?}', [FriendRequestController::class, 'toggleFriendRequest'])->name('friend.request.toggle');
    Route::post('friend-requests/{friend_requests}/accept', [FriendRequestController::class, 'acceptFriendRequest'])->name('friend.request.accept');
    Route::post('friend-requests/{friend_requests}/reject', [FriendRequestController::class, 'rejectFriendRequest'])->name('friend.request.reject');
    
    // Unfriend a user
    Route::post('friend/{friend_requests}/unfriend', [FriendRequestController::class, 'unfriend'])->name('unfriend');

    // Logout user
    Route::get('logout', [UserAuthController::class, 'logout'])->name('user.logout');
});





