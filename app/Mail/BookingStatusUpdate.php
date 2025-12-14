<?php

namespace App\Mail;

use App\Models\CounselingSession;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingStatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $session;

    public function __construct(CounselingSession $session)
    {
        $this->session = $session;
    }

    public function envelope(): Envelope
    {
        $status = ucfirst($this->session->status);
        return new Envelope(
            subject: "🔔 Status Konseling: $status",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking_status',
        );
    }
}
