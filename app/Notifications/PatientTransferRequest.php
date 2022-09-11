<?php

namespace App\Notifications;

use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PatientTransferRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Patient $patient, $hospital, $user)
    {
        $this->patient = $patient;
        $this->hospital = $hospital;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => __('You have a new transfer request from :patient to :hospital instead of :old_hospital', ['patient' => $this->patient->name, 'hospital' => $this->hospital->name, 'old_hospital' => $this->patient->hospital->name]),
            'sub_message' => __('The transfer request was requested by :user',['user'=>$this->user->name]),
            'patient_id' => $this->patient->id,
            'patient_name' => $this->patient->name,
            'hospital_id' => $this->hospital->id,
            'hospital_name' => $this->hospital->name,
            'user_id' => $this->user->id,
            'link' => route('dashboard.patients.edit', $this->patient->id),
        ];
    }
}
