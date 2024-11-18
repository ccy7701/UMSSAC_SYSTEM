<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService) {
        $this->notificationService = $notificationService;
    }

    public function fetchAllNotifications() {
        return $this->notificationService->getAllNotifications();
    }

    public function deleteNotification(Request $request) {
        return $this->notificationService->handleDeleteNotification($request);
    }
}
