<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContractInvoice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $user_type;
    public $file_name;


    public function __construct($user, $user_type, $file_name)
    {
        $this->user = $user;
        $this->user_type = $user_type;
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
            return $this->subject('INEX Invoice Due')
                ->from('support@inex.net', "INEX Digital Billboard Advertising")
                ->attach('public/pdf/'.$this->file_name, [
                    'as' => $this->file_name,
                    'mime' => 'application/pdf',
                ])
                ->view('mail.ContractInvoice');
        }
        else{
            return $this->subject('INEX Invoice Due')
                ->from('support@inex.net', "INEX Digital Billboard Advertising")
                ->view('mail.ContractInvoice');
        }
    }
}
