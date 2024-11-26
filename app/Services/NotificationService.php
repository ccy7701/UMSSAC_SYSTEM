<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Profile;
use App\Models\Notification;
use App\Models\Club;
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
    public function prepareClubCreationRequestNotifications($clubCreationRequest) {
        $requester = $this->getRequester($clubCreationRequest->requester_profile_id);

        // Get the admin account
        $account = Account::where('account_email_address', 'umssacs@gmail.com')->first();

        // Prepare the in-system notification for the admin
        $notificationData = [
            'profile_id' => $account->profile->profile_id,
            'notification_type' => 'club_creation_request',
            'notification_title' => 'Club Creation Request',
            'notification_message' => 'A request has been made by ' . $requester->account->account_full_name . ' to create a new club: ' . $clubCreationRequest->club_name . '.',
            'is_read' => 0,
        ];
        Notification::create($notificationData);

        // Then, send the notification email to the admin
        Mail::to('umssacs@gmail.com')->send(new ClubCreationRequestNotification($clubCreationRequest, $requester));

        return 'Club creation request notification sent successfully';
    }

    /**
     * Handle sending the club creation acceptance notification to the user who made the request.
     *
     * @param \App\Models\ClubCreationRequest $clubCreationRequest
     * @param \App\Models\Club $club
     */
    public function prepareClubCreationAcceptNotifications($clubCreationRequest, $club) {
        $requester = $this->getRequester($clubCreationRequest->requester_profile_id);
        $targetEmail = $requester->account->account_email_address;

        $notificationData = [
            'profile_id' => $requester->profile_id,
            'notification_type' => 'club_creation_accept',
            'notification_title' => 'Club Creation Request Accepted',
            'notification_message' => 'Your request to create the club: ' . $clubCreationRequest->club_name . ' has been accepted.',
            'is_read' => 0,
        ];
        Notification::create($notificationData);

        // Then, send the notification email to the requester
        Mail::to($targetEmail)->send(new ClubCreationAcceptanceNotification($requester, $club));

        return 'Club creation acceptance notification sent successfully';
    }

    /**
     * Handle sending the club creation rejection notification to the user who made the request.
     *
     * @param \App\Models\ClubCreationRequest $clubCreationRequest
     */
    public function prepareClubCreationRejectNotifications($clubCreationRequest) {
        $requester = $this->getRequester($clubCreationRequest->requester_profile_id);
        $targetEmail = $requester->account->account_email_address;

        // Prepare the in-system notification for the requester
        $notificationData = [
            'profile_id' => $requester->profile_id,
            'notification_type' => 'club_creation_reject',
            'notification_title' => 'Club Creation Request Rejected',
            'notification_message' => 'Your request to create the club: ' . $clubCreationRequest->club_name . ' has been rejected.',
            'is_read' => 0,
        ];
        Notification::create($notificationData);

        // Then, send the notification email to the requester
        Mail::to($targetEmail)->send(new ClubCreationRejectionNotification($clubCreationRequest, $requester));

        return 'Club creation rejection notification sent successfully';
    }

    /**
     * Handle sending a join club rejection notification (Notification::class)
     * to the user who made the request.
     *
     * @param \App\Models\ClubMembership $clubMembership
     */
    public function prepareJoinRejectionNotification($clubMembership) {
        $requester = $this->getRequester($clubMembership->profile_id);

        // Create the notification content
        $notificationData = [
            'profile_id' => $requester->profile_id,
            'notification_type' => 'join_rejection',
            'notification_title' => 'Join Request Rejected',
            'notification_message' => 'Your request to join the club ' . $clubMembership->club->club_name . ' has been rejected.',
            'is_read' => 0,
        ];

        // Create the Notification object
        Notification::create($notificationData);

        return 'Join rejection notification created successfully';
    }

    /**
     * Handle sending a join club acceptance notification (Notification::class)
     * to the user who made the request.
     *
     * @param \App\Models\ClubMembership $clubMembership
     */
    public function prepareJoinAcceptanceNotification($clubMembership) {
        $requester = $this->getRequester($clubMembership->profile_id);

        // Create the notification content
        $notificationData = [
            'profile_id' => $requester->profile_id,
            'notification_type' => 'join_acceptance',
            'notification_title' => 'Join Request Accepted',
            'notification_message' => 'Your request to join the club ' . $clubMembership->club->club_name . ' has been accepted.',
            'is_read' => 0,
        ];

        // Create the Notification object
        Notification::create($notificationData);

        return 'Join acceptance notification created successfully';
    }

    /**
     * Handle sending a club member access update notification to the user.
     *
     * @param array $newMembershipData
     */
    public function prepareMemberAccessUpdateNotification($newMembershipData) {
        // dd($updateData);
        $notificationMessage = null;

        $club = Club::where('club_id', $newMembershipData['club_id'])->first();

        // Prepare the notification title and message based on the new membership type
        if ($newMembershipData['new_membership_type'] == 1) {
            $notificationMessage = "You are no longer a committee member of the club: " . $club->club_name . "."; 
        } elseif ($newMembershipData['new_membership_type'] == 2) {
            $notificationMessage = "Congratulations! You are now a committee member of the club: " . $club->club_name . ".";
        }

        // Create the notification content
        $notificationData = [
            'profile_id' => $newMembershipData['profile_id'],
            'notification_type' => 'club_membership_update',
            'notification_title' => 'Club Membership Update',
            'notification_message' => $notificationMessage,
            'is_read' => 0,
        ];

        // Create the Notification object
        Notification::create($notificationData);

        return 'Club membership update notification created successfully';
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
