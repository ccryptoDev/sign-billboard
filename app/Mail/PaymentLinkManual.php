<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentLinkManual extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $business;
    public $invoice;
    public $file_name;

    public function __construct($user, $business, $invoice, $file_name)
    {
        $this->user = $user;
        $this->business = $business;
        $this->invoice = $invoice;
        $this->file_name = $file_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->file_name != ""){
            return $this->subject('INEX - Invoice')
                ->from('support@inex.net', "INEX Digital Billboard Advertising")
                ->attach('public/pdf/'.$this->file_name, [
                    'as' => $this->file_name,
                    'mime' => 'application/pdf',
                ])
                ->view('mail.manual.payInvoiceManual');
        }
        else{
            return $this->subject('INEX - Invoice')
                ->from('support@inex.net', "INEX Digital Billboard Advertising")
                ->view('mail.manual.payInvoiceManual');
        }
        // return $this->subject('INEX Digital Billboard Advertising')
        //     ->from('support@inex.net', 'INEX - Invoice')
        //     ->view('mail.manual.payInvoiceManual');
    }
}
