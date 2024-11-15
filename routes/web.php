<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\BartaMediaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    Route::get('/user/{user_name}', [UserController::class, 'userProfileShow'])->name('user.profile.show');
    // Edit Profile 
    Route::get('/user/profile/edit', [UserController::class, 'userProfileEdit'])->name('user.profile.edit');
    // Handle User Profile Update
    Route::post('/user/profile/edit', [UserController::class, 'userProfileUpdate'])->name('user.profile.update');
    
    // Post Routes
    Route::resource('posts', PostController::class);

    // Spatie's Media Delete Route
    Route::delete('media/{id}', [BartaMediaController::class, 'destroy'])->name('media.delete');

    // Logout user
    Route::get('logout', [UserAuthController::class, 'logout'])->name('user.logout');
});





