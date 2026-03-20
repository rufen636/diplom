<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return inertia('Notifications/Index', [
            'notifications' => $notifications
        ]);
    }

    public function recent()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->data['type'] ?? null,
                    'title' => $notification->data['title'] ?? null,
                    'message' => $notification->data['message'] ?? null,
                    'data' => $notification->data,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at,
                    'action_url' => $notification->data['action_url'] ?? null
                ];
            });

        return response()->json($notifications);
    }

    public function getUnreadCount()
    {
        $count = Auth::user()->unreadNotifications()->count();

        return response()->json(['count' => $count]);
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back();
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);

        return back();
    }

    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        return back();
    }
}
