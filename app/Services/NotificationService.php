<?php

namespace App\Services;

use App\Mail\ClubCreationRequestNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\Profile;

class NotificationService
{
    /**
     * Handle sending a club creation request notification email to the admin.
     *
     * @param \App\Models\ClubCreationRequest $clubCreationRequest
     */
    public function prepareClubCreationRequestEmail($clubCreationRequest) {
        $requester = Profile::where('profile_id', $clubCreationRequest->requester_profile_id)
            ->with([
                'account' => function($query) {
                    $query->select(
                        'account_id',
                        'account_full_name',
                        'account_email_address',
                        'account_contact_number'
                    );
                }
            ])
            ->first();

        Mail::to('umssacs@gmail.com')->send(new ClubCreationRequestNotification($clubCreationRequest, $requester));

        return 'Club creation request notification sent successfully';
    }
}
