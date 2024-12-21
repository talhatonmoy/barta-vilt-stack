<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Services\TimelineService;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\UserResource;
use App\Services\PostCardComponentService;

class TimelineController extends Controller
{
    public $timelineService, $postCardComponentService, $postService;
    public function __construct(
        TimelineService $timelineService, 
        PostCardComponentService $postCardComponentService
        )
    {
        $this->timelineService = $timelineService;
        $this->postCardComponentService = $postCardComponentService;
    }


public function timelinePage(){
        $postData = $this->postCardComponentService->getLatestPostCollectionFromAllUsers();
        $userData = $this->postCardComponentService->getUserDataWithDetails();

        return Inertia::render('User/TimeLine', [
            'timelinePostsData' => PostResource::collection($postData),
            'userData' => UserResource::make($userData)
        ]);
    }

}
