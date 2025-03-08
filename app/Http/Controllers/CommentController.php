<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Str;
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
     * Store a newly created comment.
     */
    public function store(CommentStoreRequest $request)
    {
        // Validation
        $validatedData = $request->validated();
        // Authoriation
        $this->authorize('create', Comment::class);
        // Store
        $comment = $this->commentService->storeComment($validatedData);

        // Notify Post Author
        $comment->load('post.user');
        if($comment->post->user_id != auth()->id()){s
            Notification::send($comment->post->user, new NewComment($comment));
        }
        return back();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CommentUpdateRequest $request, Comment $comment)
    {
        // Validation
        $validatedData = $request->validated();

        // Authorization
        $this->authorize('update', $comment);
        
        // Update 
        $this->commentService->updateComment($comment, $validatedData);

        // Redirect
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        // Authorization
        $this->authorize('delete', $comment);
        
        // Delete
        $comment->delete();

        // Redirect
        return back();
    }
}
