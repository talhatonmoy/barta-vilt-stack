<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use App\Models\Comment;
use App\Models\Comments;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Helpers\MediaCollection;
use App\Helpers\ReusableHelpers;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;

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
        $post = Post::create($dataToInsert);
        // $request->user()->posts()->create($dataToInsert);
        
        // Handling Multiple File Upload
        if ($request->hasFile('post_images')) {
            $images = $request->file('post_images');
            foreach ($images as $image) {
                $post->addMedia($image)->toMediaCollection(MediaCollection::PostImage);
            }
        }
        return redirect()->route('user.timeline');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $postInstance = $this->postService->getThePostInstanceFrom($uuid);
        $this->authorize('viewAny', $postInstance);

        $postDetail = $this->postService->getPostDetailWithRelatedUserDataFrom($uuid);
        $comments  = $this->commentService->getCommentsOfThisPostWithUserDataFrom($uuid);
        
        return Inertia::render('Post/SinglePost', [
            'postDetail' => $postDetail,
            'allComments' => CommentResource::collection($comments),
            'can' => [
                'update_post' => request()->user()->can('update', $postInstance),
                'delete_post' => request()->user()->can('delete', $postInstance),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $postInstance = $this->postService->getThePostInstanceFrom($uuid);
        $this->authorize('update', $postInstance);
        
        $postDetail = Post::with('media')->select('id','uuid', 'post_body')
            ->where('uuid', $uuid)
            ->firstOrFail();

        $formattedPostDetail = [
            'uuid' => $postDetail['uuid'],
            'post_body' => $postDetail['post_body'],
            'post_images' => $postDetail->media->map(function ($eachMedia) {
                return [
                    'id' => $eachMedia->id,
                    'url' => $eachMedia->getUrl(),
                ];
            })
        ];
        return Inertia::render('Post/EditPost', ['postDetail' => $formattedPostDetail]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        $validatedData  = $request->all();
        dd($validatedData);
        return Inertia::render('Test', ['validatedData' => $validatedData]);

        
        // $post = Post::where('uuid', $uuid);
        // $this->authorize('update', $post);
        // $dataToUpdate = [
        //     'post_body' => $validatedData['post_body'],
        //     'excerpt' => Str::limit($validatedData['post_body'], 250, '....'),
        // ];
        // $post->update($dataToUpdate);

        // // Uploading New Images
        // if($request->hasFile('post_images')){
        //     $images = $request->file('post_images');
        //     foreach ($images as $image){
        //         $post->addMedia($image)->toMediaCollection(MediaCollection::PostImage);
        //     }
        // }
        // return redirect()->route('posts.show', $uuid);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $post = $this->postService->getThePostInstanceFrom($uuid);
        $this->authorize('delete', $post);
        //Deleting related comments
        $post->comments()->delete();
        //Delete the post
        $post->delete();
        return redirect()->route('user.timeline');
    }
}
