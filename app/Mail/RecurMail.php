<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecurMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $campaign;
    public $file_name;
    public $subInvoice;

    public function __construct($user, $campaign, $file_name, $subInvoice)
    {
        $this->user = $user;
        $this->campaign = $campaign;
        $this->file_name = $file_name;
        $this->subInvoice = $subInvoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->file_name != ""){
            return $this->subject('Payment Invoice')
                ->from('billing@inex.net', "INEX Digital Billboard Advertising")
                ->attach('public/pdf/'.$this->file_name, [
                    'as' => $this->file_name,
                    'mime' => 'application/pdf',
                ])
                ->view('mail.RecurMail');
        }
        else{
            return $this->subject('Payment Invoice')
                ->from('billing@inex.net', "INEX Digital Billboard Advertising")
                ->view('mail.RecurMail');
        }
    }
}
