<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Notifications\Post\NewComment;
use App\Services\CommentService;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{
    protected $commentService;
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentStoreRequest $request)
    {
        $this->authorize('create', Comment::class);
        $validatedData = $request->validated();
        $comment = $this->commentService->storeComment($validatedData);

        // Notify Post Author
        $comment->load('post.user');
        if($comment->post->user_id != auth()->id()){
            Notification::send($comment->post->user, new NewComment($comment));
        }

        return back();
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentUpdateRequest $request, string $uuid)
    {
        $comment = Comment::where('uuid', $uuid)->firstOrFail();
        $this->authorize('update', $comment);
        $validatedData = $request->validated();
        $comment->update([
            'comment_body' => $validatedData['comment_body'],
            'excerpt' => Str::limit($validatedData['comment_body'], '100', '...')
        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $comment = Comment::where('uuid', $uuid)->firstOrFail();
        $this->authorize('delete', $comment);
        
        $comment->delete();
        return back();
    }
}
