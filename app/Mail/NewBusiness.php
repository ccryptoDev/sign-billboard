<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewBusiness extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $account;
    public $flag;

    public function __construct($user,$account,$flag)
    {
        $this->user = $user;
        $this->account = $account;
        $this->flag = $flag;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('INEX Digital Billboard Advertising')
                    ->from('support@inex.net', 'INEX New Account Assignment')
                    ->view('mail.newbusiness');
    }
}
