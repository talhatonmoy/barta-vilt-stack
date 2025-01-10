<?php 

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Str;
use App\Helpers\MediaCollection;

class PostService{

    /**
     * Store Post
     */
    public function storePost($request, $validatedData){
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
    }

    /**
     * Providing ready-to-share post details along 
     * with related user data for the Vue component.
     */
    public function getPostDetailWithAllData(object $post){
        $post->load(['user.media', 'likes.user', 'comments.user']);
        $post->loadCount('comments', 'likes');
        return $post;
    }

    /**
     * Handleing media upload
     */
    public function handleMediaUpload($request, $post){
        $uploadedMedia = $request->file('media');
        if ($uploadedMedia) {
            foreach ($uploadedMedia as $media) {
                $post->addMedia($media)->toMediaCollection(MediaCollection::PostImage);
            }
        }
    }

    /**
     * Delete post with dependencies
     */
    public function deletePostWithDependecies($post){
        $post->comments()->delete();
        $post->delete();
    }

    /**
     * Providing post instance from post uuid
     */
    public function getThePostInstanceFrom($uuid){
        return Post::where('uuid', $uuid)->firstOrFail();
    }


}