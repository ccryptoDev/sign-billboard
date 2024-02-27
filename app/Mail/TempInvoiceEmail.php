<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TempInvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $campaign;
    public $invoice;
    public $user_flag;
    public $file_name;

    public function __construct($user, $campaign, $invoice, $user_flag, $file_name)
    {
        $this->user = $user;
        $this->invoice = $invoice;
        $this->campaign = $campaign;
        $this->user_flag = $user_flag;
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
            return $this->subject('Temporary Advertising Campaign Extension')
                ->from('support@inex.net', "INEX Digital Billboard Advertising")
                ->attach('public/pdf/'.$this->file_name, [
                    'as' => $this->file_name,
                    'mime' => 'application/pdf',
                ])
                ->view('mail.TempInvoice');
        }
        else{
            return $this->subject('Temporary Advertising Campaign Extension')
                ->from('support@inex.net', "INEX Digital Billboard Advertising")
                ->view('mail.TempInvoice');
        }
    }
}
