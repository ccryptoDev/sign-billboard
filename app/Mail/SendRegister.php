<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRegister extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $primary;
    public $account_manager;
    public $flag; // 0 : Secondary TA, 1 : Primary TA

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $primary, $account_manager, $flag)
    {
        $this->user = $user;
        $this->primary = $primary;
        $this->account_manager = $account_manager;
        $this->flag = $flag;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('INEX Secondary Trusted Agent Added')
            ->from('support@inex.net', 'INEX Digital Billboard Advertising')
            ->view('mail.register');
    }
}