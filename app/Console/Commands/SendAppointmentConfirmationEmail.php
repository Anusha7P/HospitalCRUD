<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Api\V1\Appointment;
use App\Mail\AppointmentConfirmationMail;
use Illuminate\Support\Facades\Mail;

class SendAppointmentConfirmationEmail extends Command
{
    protected $signature = 'appointment:send-confirmation {appointmentId}';
    protected $description = 'Send appointment confirmation email';

    public function handle()
    {
            // Mail::to($appointment->patient->email)->send(new AppointmentConfirmationMail($appointment));

        $appointmentId = $this->argument('appointmentId');
        $appointment = Appointment::find($appointmentId);
        log('test'. $appointmentId);

        if ($appointment && $appointment->patient && $appointment->patient->email) {
            Mail::to($appointment->patient->email)->send(
                new AppointmentConfirmationMail($appointment)
            );
            $this->info('Appointment confirmation email sent!');
        } else {
            $this->error('Appointment or email not found.');
        }
    }
}
