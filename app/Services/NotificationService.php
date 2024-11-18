<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Profile;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClubCreationRequestNotification;
use App\Mail\ClubCreationRejectionNotification;
use App\Mail\ClubCreationAcceptanceNotification;

class NotificationService
{
    /**
     * Get all the logged in user's notifications
     */
    public function getAllNotifications() {
        $notifications = Notification::where('profile_id', profile()->profile_id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($notification) {
                $notification->formatted_datetime = Carbon::parse($notification->created_at)->format('Y-m-d h:i A');
                return $notification;
            });

        return response()->json($notifications);
    }

    /**
     * Handle updating the notification to mark it as read
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleSetNotificationToRead(Request $request) {
        // Validate that notification_id is provided
        $request->validate([
            'notification_id' => 'required|integer|exists:notification,notification_id',
        ]);

        $notification = Notification::where('notification_id', $request->notification_id)->firstOrFail();
        $notification->is_read = 1;
        $status = $notification->save();

        return $status
            ? response()->json(['success' => 'Notification marked as read.'])
            : response()->json(['error' => 'Could not delete notification.'], 404);
    }
    
    /**
     * Handle deletion of the notification based on notification ID
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleDeleteNotification(Request $request) {
        // Validate that notification_id is provided
        $request->validate([
            'notification_id' => 'required|integer|exists:notification,notification_id',
        ]);

        $notification = Notification::where('notification_id', $request->notification_id)->firstOrFail();
        $status = $notification->delete();

        return $status
            ? response()->json(['success' => 'Notification deleted successfully.'])
            : response()->json(['error' => 'Could not delete notification.'], 404);
    }

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
