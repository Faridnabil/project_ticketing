<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentCustomer extends Notification
{
    use Queueable;
    private $DataCustomer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($DataCustomer)
    {
        $this->DataCustomer = $DataCustomer;
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
            ->line($this->DataCustomer['body'])
            ->action($this->DataCustomer['Text'], $this->DataCustomer['Url'])
            ->line($this->DataCustomer['thanks']);
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
            'name' => $this->DataCustomer['name'],
            'body' => $this->DataCustomer['body'],
            'thanks' => $this->DataCustomer['thanks'],
            'Text' => $this->DataCustomer['Text'],
            'Url' => $this->DataCustomer['Url'],
            'customer_id' => $this->DataCustomer['customer_id'],
            'type' => $this->DataCustomer['type'], // Menambahkan properti 'type'
        ];
    }
}
