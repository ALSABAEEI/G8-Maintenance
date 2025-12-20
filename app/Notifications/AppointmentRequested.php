<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentRequested extends Notification
{
    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Appointment Request')
            ->line('A student has requested an appointment with you.')
            ->line('Appointment details:')
            ->line('Date: ' . $this->appointment->slot->date)
            ->line('Time: ' . $this->appointment->slot->start_time . ' - ' . $this->appointment->slot->end_time)
            ->action('View Appointment', url('/appointments/' . $this->appointment->id));
    }
}
