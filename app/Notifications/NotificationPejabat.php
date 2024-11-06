<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationPejabat extends Notification
{
    use Queueable;
    private $DataPejabat;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($DataPejabat)
    {
        $this->DataPejabat = $DataPejabat;
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
            ->line($this->DataPejabat['body'])
            ->action($this->DataPejabat['Text'], $this->DataPejabat['Url'])
            ->line($this->DataPejabat['thanks']);
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
            'name' => $this->DataPejabat['name'],
            'body' => $this->DataPejabat['body'],
            'thanks' => $this->DataPejabat['thanks'],
            'Text' => $this->DataPejabat['Text'],
            'Url' => $this->DataPejabat['Url'],
            'pejabat_id' => rand(1111, 9999),
        ];
    }
}
