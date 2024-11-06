<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TestCustomEmail;
use Illuminate\Support\Facades\Mail;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService) {
        $this->notificationService = $notificationService;
    }

    public function sendCustomEmail1() {
        return $this->notificationService->handleCustomEmail1();
    }
}
