<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationKoordinator extends Notification
{
    use Queueable;
    private $DataKoordinasi;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($DataKoordinasi)
    {
        $this->DataKoordinasi = $DataKoordinasi;
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
        // return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //         ->line($this->DataKoordinasi['body'])
    //         ->action($this->DataKoordinasi['Text'], $this->DataKoordinasi['Url'])
    //         ->line($this->DataKoordinasi['thanks']);
    // }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Notifikasi Tiket')
            ->view('emails.notificationKoordinator', ['data' => $this->DataKoordinasi]);
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
            'name' => $this->DataKoordinasi['name'],
            'body' => $this->DataKoordinasi['body'],
            'thanks' => $this->DataKoordinasi['thanks'],
            'Text' => $this->DataKoordinasi['Text'],
            'Url' => $this->DataKoordinasi['Url'],
            'koordinasi_id' => rand(1111, 9999),
        ];
    }
}
