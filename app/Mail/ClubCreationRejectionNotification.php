<?php

namespace App\Mail;

use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\ClubCreationRequest;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClubCreationRejectionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $clubCreationRequest;
    public $requester;

    /**
     * Create a new message instance.
     *
     * @param ClubCreationRequest $clubCreationRequest
     * @param Profile $requester
     */
    public function __construct(ClubCreationRequest $clubCreationRequest, Profile $requester)
    {
        $this->clubCreationRequest = $clubCreationRequest;
        $this->requester = $requester;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Request to create ' . $this->clubCreationRequest->club_name . ' rejected',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.club-creation-rejected',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
