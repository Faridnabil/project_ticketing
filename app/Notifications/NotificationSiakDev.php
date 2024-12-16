<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationSiakDev extends Notification
{
    use Queueable;
    private $DataSiakDev;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($DataSiakDev)
    {
        $this->DataSiakDev = $DataSiakDev;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['mail', 'database'];
        return ['database'];
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
    //         ->line($this->DataSiakDev['body'])
    //         ->action($this->DataSiakDev['Text'], $this->DataSiakDev['Url'])
    //         ->line($this->DataSiakDev['thanks']);
    // }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Notifikasi Tiket')
            ->view('emails.notificationEmail', [
                'data' => $this->DataSiakDev
            ]);
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
            'name' => $this->DataSiakDev['name'],
            'body' => $this->DataSiakDev['body'],
            'thanks' => $this->DataSiakDev['thanks'],
            'Text' => $this->DataSiakDev['Text'],
            'Url' => $this->DataSiakDev['Url'],
            'koordinasi_id' => rand(1111, 9999),
        ];
    }
}
