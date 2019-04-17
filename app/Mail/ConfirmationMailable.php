<?php

namespace boardit\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use boardit\Order;

class ConfirmationMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @param Order $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("boarditgames@gmail.com", 'Boarditgames')
            ->subject('Orderbekräftelse')
            ->view('emails.orderConfirmation')->with('order', $this->order);
    }
}
