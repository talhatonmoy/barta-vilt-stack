<?php

namespace App\Http\Controllers\Search;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\UserResource;
use App\Services\PostCardComponentService;
use Inertia\Inertia;

class SearchController extends Controller
{
    public $postCardComponentService;
    public function __construct(PostCardComponentService $postCardComponentService)
    {
        $this->postCardComponentService = $postCardComponentService;
    }

    public function search(Request $request)  
    {
        // Validation
        $request->validate([
            'searchQuery' => 'required|string|max:255',
        ]);

        // Prepare search term
        $searchTerm = "%{$request->searchQuery}%";

        // Search users
        $users = User::with(['media', 'receivedFriendRequests', 'friends', 'sentFriendRequests'])
            ->where('first_name', 'like', $searchTerm)
            ->orWhere('user_name', 'like', $searchTerm)
            ->orWhere('last_name', 'like', $searchTerm)
            ->get();
        
        // Search Posts
        $posts = $this->postCardComponentService->getLatestPostCollectionFromAllUsers($request->searchQuery);

        // dd($posts);
        return Inertia::render('Search/SearchResult', [
            'users' => UserResource::collection($users),
            'posts' => PostResource::collection($posts),
            'searchTerm' => $request->searchQuery
        ]);
    }
}
