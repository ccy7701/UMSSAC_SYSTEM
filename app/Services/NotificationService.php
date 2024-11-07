<?php

namespace App\Services;

use App\Mail\TestCustomEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Club;

class NotificationService
{
    /**
     * Example method to handle club notifications.
     *
     * @param int $clubId
     * @return void
     */
    public function handleClubEmailTest($club) {
        // Fetch then prepare the club data from the club servfunc
        $emailData = [
            'title' => "Club Description: {$club->club_name}",
            'message' => "Join our club - {$club->club_name} - today!",
        ];

        Mail::to('example@email.com')->send(new TestCustomEmail($emailData));

        return 'Custom email test send successfully';
    }
}
