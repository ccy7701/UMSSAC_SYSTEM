<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\ClubCreationRequest;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClubCreationRequestNotification extends Mailable
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
    public function __construct(ClubCreationRequest $clubCreationRequest, $requester)
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
            subject: 'Request to create new club: ' . $this->clubCreationRequest->club_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.club-creation-request',
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
