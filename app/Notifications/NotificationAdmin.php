<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationAdmin extends Notification
{
    use Queueable;
    private $DataAdmin;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($DataAdmin)
    {
        $this->DataAdmin = $DataAdmin;
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line($this->DataAdmin['body'])
            ->action($this->DataAdmin['Text'], $this->DataAdmin['Url'])
            ->line($this->DataAdmin['thanks']);
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
            'name' => $this->DataAdmin['name'],
            'body' => $this->DataAdmin['body'],
            'thanks' => $this->DataAdmin['thanks'],
            'Text' => $this->DataAdmin['Text'],
            'Url' => $this->DataAdmin['Url'],
            'admin_id' => rand(1111, 9999),
        ];
    }
}
