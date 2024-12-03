<?php 

namespace App\Services;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Str;

class CommentService{
    /**
     * Store Comment
     */
    public function storeComment($validatedData){
        $post = Post::select(['id', 'uuid'])->where('uuid', $validatedData['post_uuid'])->firstOrFail();
        $dataToInsert = [
            'uuid' => Str::uuid(),
            'user_id' => auth()->id(),
            'comment_body' => $validatedData['comment_body'],
            'excerpt' => Str::limit($validatedData['comment_body'], '100', '...'),
            'post_uuid' => $validatedData['post_uuid'],
        ];
        $comment = $post->comments()->create($dataToInsert);
        return $comment;
    }

    /**
     * Providing Comment Collections For a Single Post
     */
    public function getCommentsOfThisPostWithUserDataFrom($post_uuid){
        return Comment::with('user.media')->where('post_uuid', $post_uuid)->get();
    }
}