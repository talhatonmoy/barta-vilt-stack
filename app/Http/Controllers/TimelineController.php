<?php

namespace App\Http\Controllers;

use App\Helpers\ReusableHelpers;
use App\Services\PostCardComponentService;
use App\Services\PostService;
use App\Services\TimelineService;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        return Inertia::render('User/TimeLine', [
            'timelinePosts' => $postData['posts'],
            'nextPageUrl' => $postData['nextPageUrl'],
        ]);
    }
}
