<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications;

        return view('pages.notifications', compact('notifications'));
    }
    public function read(DatabaseNotification $notification)
    {
        $notification->markAsRead();

        return redirect()->route('notifications.index');
    }
    public function unread(DatabaseNotification $notification)
    {
        $notification->markAsUnread();

        return redirect()->route('notifications.index');
    }

    public function readAll()
    {
        $user = auth()->user();
        $user->notifications->markAsRead();

        return redirect()->route('notifications.index');
    }
}
