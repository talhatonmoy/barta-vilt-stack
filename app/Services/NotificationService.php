<?php 

namespace App\Services;

use App\Http\Resources\Notification\NotificationResource;

class NotificationService{

    /**
     * Providing all notifications
     */
    public function getAllNotifications(){
        $allNotifications = request()->user()->notifications;
        $allNotifications->markAsRead();
        return NotificationResource::collection($allNotifications);
    }

    /**
     * Providing few latest notification
     */
    public function getFewLatestNotifications(Int $limit = 7){
        return NotificationResource::collection(request()->user()->notifications->take($limit));
    }

    /**
     * Providing unread notifications
     */
    public function getUnreadNotificaions(){
        $user  = request()->user();
        return NotificationResource::collection($user->unreadNotifications);
    }
}