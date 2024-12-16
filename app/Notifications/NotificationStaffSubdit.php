<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationStaffSubdit extends Notification
{
    use Queueable;
    private $DataStaffSubdit;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($DataStaffSubdit)
    {
        $this->DataStaffSubdit = $DataStaffSubdit;
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
    //         ->line($this->DataStaffSubdit['body'])
    //         ->action($this->DataStaffSubdit['Text'], $this->DataStaffSubdit['Url'])
    //         ->line($this->DataStaffSubdit['thanks']);
    // }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Notifikasi Tiket')
            ->view('emails.notificationEmail', [
                'data' => $this->DataStaffSubdit
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
            'name' => $this->DataStaffSubdit['name'],
            'body' => $this->DataStaffSubdit['body'],
            'thanks' => $this->DataStaffSubdit['thanks'],
            'Text' => $this->DataStaffSubdit['Text'],
            'Url' => $this->DataStaffSubdit['Url'],
            'koordinasi_id' => rand(1111, 9999),
        ];
    }
}
