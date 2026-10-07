<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

     public $customer;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this
            ->subject('Customer #' . $this->customer->id . ' NEW CUSTOMER - Jamwal Motors and Spares')
            ->view('emails.customer-created');
    }
}
