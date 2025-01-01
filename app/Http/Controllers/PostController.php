<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Helpers\MediaCollection;
use App\Services\CommentService;
use App\Http\Requests\PostStoreRequest;
use App\Http\Resources\Post\PostEditResource;
use App\Http\Resources\Post\PostResource;
use PhpParser\Node\Expr\Cast\Object_;

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
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $validatedData  = $request->validated();
        $this->authorize('create', Post::class);
        $dataToInsert = [
            'uuid' => Str::uuid()->toString(),
            'post_body' => $validatedData['post_body'],
            'excerpt' => Str::limit($validatedData['post_body'], 250, '....'),
        ]; 
        $post = Post::make($dataToInsert);
        $request->user()->posts()->save($post);
        
        // Handling Multiple File Upload
        if ($request->hasFile('post_images')) {
            $images = $request->file('post_images');
            foreach ($images as $image) {
                $post->addMedia($image)->toMediaCollection(MediaCollection::PostImage);
            }
        }
        // return redirect()->route('user.timeline');
        return to_route('user.timeline');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $this->authorize('viewAny', $post);
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
     * Show the form for editing the specified resource.
     */
    public function edit(object $postInstance)
    {
        $this->authorize('update', $postInstance);

        $postDetail = $postInstance->load('media');

        return Inertia::render('Post/EditPost', [
            'postDetail' => PostEditResource::make($postDetail)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Object $post)
    {
        // Validate
        $validatedData  = $request->input();

        dd($validatedData);

        // Do DB oparations

        return $validatedData;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $post = $this->postService->getThePostInstanceFrom($uuid);
        $this->authorize('delete', $post);
        $post->comments()->delete();
        $post->delete();
        return redirect()->route('user.timeline');
    }
}
