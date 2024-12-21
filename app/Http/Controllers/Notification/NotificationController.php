<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationResource;
use Inertia\Inertia;

class NotificationController extends Controller
{
    // For All notifications page
    public function allNotifications()
    {
        $allNotifications = auth()->user()->notifications;
        $allNotifications->markAsRead();
        $userNotifications = NotificationResource::collection(auth()->user()->notifications);
        return Inertia::render('Notifications/AllNotifications', compact('userNotifications'));
    }

    // For All notifications page
    public function lastFewNotification()
    {
        $allNotifications = auth()->user()->notifications;
        $latFewNotifications = NotificationResource::collection(auth()->user()->notifications->take(7));
        return $latFewNotifications;
    }

    // For notifications tray
    public function notificationTray(){
        $user  = auth()->user();
        $unreadNotifications = $user->unreadNotifications;
        return NotificationResource::collection($unreadNotifications);
    }

    public function markAllAsRead(){
        $userNotifications = auth()->user()->notifications;
        $userNotifications->markAsRead();
        return back();
    }


}
