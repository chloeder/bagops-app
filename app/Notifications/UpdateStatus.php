<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateStatus extends Notification
{
    use Queueable;
    use Queueable;
    public $getStatus;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($getStatus)
    {
        $this->getStatus = $getStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            ->greeting('LAPOR - OPS APPLICATION')
            ->subject('Status Berkas')
            ->line('Berkas Anda Telah Diverifikasi, Silahkan Melakukan Login Untuk Melihat Status Berkas Anda')
            ->action('Login Disini', url(route('berkas')));
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
            'no_berkas' => $this->getStatus->nomor_berkas,
            'status' => $this->getStatus->status->nama,
            'user' => $this->getStatus->user->name,
        ];
    }
}
