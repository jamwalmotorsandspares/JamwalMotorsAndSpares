<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCustomerNotification extends Notification
{
    use Queueable;

    public $customer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
     public function __construct($customer)
    {
        $this->customer = $customer;
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
        // return ['mail'];
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
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'New Customer',
            'title' => 'New Customer Registered',
            'message' => $this->customer->first_name .' '.$this->customer->last_name . ' has registered.',
            'customer_id' => $this->customer->id,
            'url' => url('/en/dashboard/clients/' . $this->customer->id),
        ];
    }
}
