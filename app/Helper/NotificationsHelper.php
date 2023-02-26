<?php

namespace App\Helper;

use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;

class NotificationsHelper
{
    static function Insert($receiverId, $text, $type)
    {
        if (Auth::id() != $receiverId) {
            $array = [
                'userId' => Auth::id(),
                'type' => $type,
                'receiverUserId' => $receiverId,
                'text' => $text,
                'isRead' => 1
            ];

            Notifications::create($array);
        }
    }
}
