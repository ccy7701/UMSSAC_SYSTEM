<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function fetchAllNotifications() {
        $notifications = Notification::where('profile_id', profile()->profile_id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($notification) {
                $notification->formatted_datetime = Carbon::parse($notification->created_at)->format('Y-m-d h:i A');
                return $notification;
            });

        return response()->json($notifications);
    }
}
