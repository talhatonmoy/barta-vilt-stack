<?php 

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Str;
use App\Helpers\MediaCollection;
use App\Helpers\ReusableHelpers;

class PostService{

    /**
     * Providing ready-to-share post details along 
     * with related user data for the Vue component.
     */
    public function getPostDetailWithRelatedUserDataFrom(string $uuid){
        $post = Post::with(['user', 'media'])
            ->select('uuid', 'user_id', 'post_body', 'created_at', 'updated_at', 'id')
            ->where('uuid', $uuid)
            ->firstOrFail();
        $postDetail = $this->prepareSinglePostDataToShare($post);
        return $postDetail;
    }

    /**
     * Formatting Single Post Data Comes 
     * with related User Data for single post
     */
    protected function prepareSinglePostDataToShare(object $post){
        $postDetail = [
            'uuid' => $post->uuid,
            'post_body' => $post->post_body,
            'last_modified_time' => ReusableHelpers::getLastModifiedTime($post->created_at, $post->updated_at),
            'last_modified_time' => ReusableHelpers::getLastModifiedTime($post->created_at, $post->updated_at),
            'postImages' => $post->getMedia(MediaCollection::PostImage)->map(function($eachMedia){
                return [
                    'file_name' => $eachMedia->file_name,
                    'url' => $eachMedia->getUrl(),
                ];
            }),
            'user' => [
                'first_name' => $post->user->first_name,
                'last_name' => $post->user->last_name,
                'user_name' => $post->user->user_name,
                'bio' => Str::limit($post->user->bio, 220, '...'),
                'profileImgUrl' => $post->user->getFirstMediaUrl(MediaCollection::UserProfileImage),
            ],
        ];
        return $postDetail;
    }
}