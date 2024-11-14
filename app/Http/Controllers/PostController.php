<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Helpers\MediaCollection;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{
    public $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $validatedData  = $request->validated();
        $dataToInsert = [
            'uuid' => Str::uuid()->toString(),
            'user_id' => auth()->id(),
            'post_body' => $validatedData['post_body'],
            'excerpt' => Str::limit($validatedData['post_body'], 250, '....'),
        ];
        $post = Post::create($dataToInsert);
        
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
        $postDetail = $this->postService->getPostDetailWithRelatedUserDataFrom($uuid);
        return Inertia::render('Post/SinglePost', ['postDetail' => $postDetail]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
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
        Post::where('uuid', $uuid)->delete();
        return redirect()->route('user.timeline');
    }
}
