<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UploadBerkas extends Notification
{
    use Queueable;
    public $berkas;
    public $satker;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($berkas, $satker)
    {
        $this->berkas = $berkas;
        $this->satker = $satker;
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
            ->subject('Berkas Baru')
            ->line('Berkas baru telah diupload oleh ' . $this->berkas->user->name . ' Dari Satuan Kerja ' . $this->satker->nama . ', dengan nomor berkas ' . $this->berkas->nomor_berkas)
            ->action('Lihat Berkas', url(route('dokumen.berkas.tertunda')));
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
            'nama' => $this->berkas->user->name,
            'no_berkas' => $this->berkas->nomor_berkas,
            'nama_berkas' => $this->berkas->judul,
            'satker' => $this->satker->nama,
        ];
    }
}
