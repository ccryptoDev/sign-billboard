<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $invoice;
    public $campaign;
    public $locations;
    public $user_flag;

    public function __construct($user, $campaign, $invoice, $locations, $user_flag)
    {
        $this->user = $user;
        $this->invoice = $invoice;
        $this->campaign = $campaign;
        $this->user_flag = $user_flag;
        $this->locations = $locations;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('INEX Digital Billboard Advertising')
            ->from('support@inex.net', "Invoice")
            ->view('mail.invoice');
    }
}
