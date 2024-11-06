<?php

namespace App\Services;

use App\Mail\TestCustomEmail;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function handleCustomEmail1() {
        $data = [
            'title' => 'Welcome to UMSSACS!',
            'message' => 'We are excited to have you on board. Enjoy exploring our features!',
        ];

        Mail::to('example@email.com')->send(new TestCustomEmail($data));

        return 'Custom email 1 send successfully';
    }
}
