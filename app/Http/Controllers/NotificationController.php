<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function markAsRead($order_id, $id)
    {
        $userUnreadNoti = auth()->user()->unreadNotifications->where('id', $id)->first();
    
        if ($userUnreadNoti) {
            $userUnreadNoti->markAsRead();
        }
        
        return redirect()->route('user.history.detail', $order_id);
    }

    public function markAsReadAll()
    {
        $userUnreadNoti = auth()->user()->unreadNotifications;
    
        if ($userUnreadNoti) {
            $userUnreadNoti->markAsRead();
        }

        return redirect()->back();
    }
}
