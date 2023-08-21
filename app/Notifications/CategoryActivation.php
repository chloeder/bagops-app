<?php

namespace App\Notifications;

use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CategoryActivation extends Notification
{
    use Queueable;
    public $category;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
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
        if ($this->category->status == 'Nonaktif') {
            return (new MailMessage)
                ->greeting('Halo, ' . $notifiable->name . ' ' . '( ' . $notifiable->satker->nama . ' )')
                ->subject('Kategori Laporan Dinonaktifkan' . ' ( ' . $this->category->nama . ' ) ')
                ->line('Kategori Laporan telah dinonaktifkan')
                ->action('Lihat Form', url(route('berkas')))
                ->line('Kategori ini telah melebihi batas waktu yang ditentukan');
        } else {

            return (new MailMessage)
                ->greeting('Halo, ' . $notifiable->name . '( ' . $notifiable->satker->nama . ' )')
                ->subject('Kategori Laporan Baru' . ' ( ' . $this->category->nama . ' ) ')
                ->line('Anda mempunyai kategori laporan baru untuk dimasukkan.')
                ->action('Lihat Form', url(route('berkas')))
                ->line('Kategori ini akan dinonaktifkan dalam 1 minggu kedepan');
        }
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
            'category_name' => $this->category->nama,
            'status' => $this->category->status,
        ];
    }
}
