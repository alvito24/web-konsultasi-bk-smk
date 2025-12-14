<?php

namespace App\Mail;

use App\Models\CounselingSession;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewBookingAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $session;

    public function __construct(CounselingSession $session)
    {
        $this->session = $session;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📅 Request Konseling Baru: ' . $this->session->student->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new_booking',
        );
    }
}
