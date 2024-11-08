<?php

namespace App\Mail;

use App\Models\Club;
use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClubCreationAcceptanceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $requester;
    public $club;

    /**
     * Create a new message instance.
     *
     * @param Profile $requester
     * @param Club $club
     */
    public function __construct(Profile $requester, Club $club)
    {
        $this->requester = $requester;
        $this->club = $club;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Request to create ' . $this->club->club_name . ' accepted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.club-creation-accepted',
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
