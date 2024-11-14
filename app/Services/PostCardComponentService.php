<?php 
namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Str;
use App\Helpers\MediaCollection;
use App\Helpers\ReusableHelpers;


class PostCardComponentService{

    /**
     * Timeline Posts (All Users)
     * Providing latest post collections with associated user data
     */
    public function getLatestPostCollectionFromAllUsers()
    {
        $data = [];
        $posts = Post::with('user')
        ->orderByDesc('created_at')->paginate(10);

        $Posts = $this->prepareCollectionDataToShare($posts);
        $data['posts'] = $Posts;
        $data['nextPageUrl'] = $posts->nextPageUrl();
        return $data;
    }



    /**
     * Formatting collection data ready to share in a Vue component.
     * 
     * For User Profile Page
     */
    protected function prepareCollectionDataToShare($postCollection)
    {
        $userPosts = $postCollection->map(function ($post) {
            return [
                'uuid' => $post->uuid,
                'excerpt' => $post->excerpt,
                'last_modified_time' => ReusableHelpers::getLastModifiedTime($post->created_at, $post->updated_at),
                'remainingPostImages' => $post->getMedia(MediaCollection::PostImage)->count() - 4,
                'postImages' => $post->getMedia(MediaCollection::PostImage)->take(4)->map(function ($eachMedia) {
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
        });
        return $userPosts;
    }
}