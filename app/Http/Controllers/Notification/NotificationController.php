<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationResource;
use App\Services\NotificationService;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notificationService)
    {
        
    }

    // For All notifications page
    public function allNotifications()
    {
        $userNotifications = $this->notificationService->getAllNotifications();
        return Inertia::render('Notifications/AllNotifications', compact('userNotifications'));
    }

    // Latest few notification for sidebar
    public function latestFewNotification()
    {
        $latFewNotifications = $this->notificationService->getFewLatestNotifications();
        return $latFewNotifications;
    }

    // For notifications tray on top header
    public function notificationTray(){
        return $this->notificationService->getUnreadNotificaions();
    }

    public function markAllAsRead(){
        $userNotifications = request()->user()->notifications;
        $userNotifications->markAsRead();
        return back();
    }


}
