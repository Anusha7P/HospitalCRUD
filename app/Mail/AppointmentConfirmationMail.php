<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;


class AppointmentConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        return $this->subject('Appointment Confirmation')
            ->view('emails.appointment')
            ->with(['appointment' => $this->appointment]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Confirmation Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment_confirmation',
            with: [
                'appointment' => $this->appointment,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
