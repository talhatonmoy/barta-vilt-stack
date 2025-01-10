<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Services\CommentService;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\Post\PostEditResource;
use App\Http\Resources\Post\PostResource;

class PostController extends Controller
{
    public $postService;
    public $commentService;
    public function __construct(PostService $postService, CommentService $commentService)
    {
        $this->postService = $postService;
        $this->commentService = $commentService;
    }


    /**
     * Store a newly created post in storage.
     */
    public function store(PostStoreRequest $request)
    {
        // Validation
        $validatedData  = $request->validated();
        // Authorization
        $this->authorize('create', Post::class);
        // Store
        $this->postService->storePost($request, $validatedData);
        // Redirect
        return redirect()->route('user.timeline');
    }

    /**
     * Display the post.
     */
    public function show(Post $post)
    {
        // Authorization
        $this->authorize('viewAny', $post);

        // Getting necessary data
        $postDetail = $this->postService->getPostDetailWithAllData($post);
        
        return Inertia::render('Post/SinglePost', [
            'postDetail' => PostResource::make($postDetail),
            'can' => [
                'update_post' => request()->user()->can('update', $post),
                'delete_post' => request()->user()->can('delete', $post),
            ]
        ]);
    }

    /**
     * Show the form for editing the post.
     */
    public function edit(object $postInstance)
    {
        // Authorization
        $this->authorize('update', $postInstance);

        // Loading necesary data
        $postDetail = $postInstance->load('media');

        return Inertia::render('Post/EditPost', [
            'postDetail' => PostEditResource::make($postDetail)
        ]);
    }

    /**
     * Update the specified post.
     * Only post body - media will be handaled via 'mediaUpload' method 
     */
    public function update(PostUpdateRequest $request, Object $post)
    {
        // Validation
        $validatedData  = $request->validated();

        // Update
        $post->update([
            'post_body' => $validatedData['post_body']
        ]);

        return redirect()->route('posts.show', $post->uuid);
    }

    /**
     * Handling Media Upload (For now - on edit post page)
     * Later will applied to create post as well
     */
    public function mediaUpload(Request $request, Post $post){
        // Validation
        $request->validate([
            'media.*' => 'required|file|mimes:jpg,jpeg,png,gif,mp4|max:2048'
        ]);

        // Upload
        $this->postService->handleMediaUpload($request, $post);

        // Response
        return response()->json([
            'postDetail' => PostEditResource::make($post->load('media'))
        ]);
    }

    /**
     * Remove the post.
     */
    public function destroy(Post $post)
    {
        // Authorization
        $this->authorize('delete', $post);

        // Delete
        $this->postService->deletePostWithDependecies($post);

        return redirect()->route('user.timeline');
    }
}
