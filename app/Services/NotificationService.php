<?php

namespace App\Services;

use App\Mail\ClubCreationRequestNotification;
use App\Mail\ClubCreationRejectionNotification;
use App\Mail\ClubCreationAcceptanceNotification;
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
        $requester = $this->getRequester($clubCreationRequest->requester_profile_id);

        Mail::to('umssacs@gmail.com')->send(new ClubCreationRequestNotification($clubCreationRequest, $requester));

        return 'Club creation request notification sent successfully';
    }

    /**
     * Handle sending the club creation acceptance notification to the user who made the request.
     * 
     * @param \App\Models\ClubCreationRequest $clubCreationRequest
     * @param \App\Models\Club $club
     */
    public function prepareClubCreationAcceptEmail($clubCreationRequest, $club) {
        $requester = $this->getRequester($clubCreationRequest->requester_profile_id);
        $targetEmail = $requester->account->account_email_address;

        Mail::to($targetEmail)->send(new ClubCreationAcceptanceNotification($requester, $club));

        return 'Club creation acceptance notification sent successfully';
    }

    /**
     * Handle sending the club creation rejection notification to the user who made the request.
     *
     * @param \App\Models\ClubCreationRequest $clubCreationRequest
     */
    public function prepareClubCreationRejectEmail($clubCreationRequest) {
        $requester = $this->getRequester($clubCreationRequest->requester_profile_id);
        $targetEmail = $requester->account->account_email_address;

        Mail::to($targetEmail)->send(new ClubCreationRejectionNotification($clubCreationRequest, $requester));

        return 'Club creation rejection notification sent successfully';
    }

    /**
     * Get the details of the user who made the request.
     */
    private function getRequester($profileId) {
        return Profile::where('profile_id', $profileId)
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
    }
}
