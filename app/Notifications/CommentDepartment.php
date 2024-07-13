<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentDepartment extends Notification
{
    use Queueable;
    private $DataDepartment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($DataDepartment)
    {
        $this->DataDepartment = $DataDepartment;
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
            ->line($this->DataDepartment['body'])
            ->action($this->DataDepartment['Text'], $this->DataDepartment['Url'])
            ->line($this->DataDepartment['thanks']);
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
            'name' => $this->DataDepartment['name'],
            'body' => $this->DataDepartment['body'],
            'thanks' => $this->DataDepartment['thanks'],
            'Text' => $this->DataDepartment['Text'],
            'Url' => $this->DataDepartment['Url'],
            'department_id' => $this->DataDepartment['department_id'],
            'type' => $this->DataDepartment['type'], // Menambahkan properti 'type'
        ];
    }
}
