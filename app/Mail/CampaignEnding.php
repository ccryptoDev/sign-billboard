<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CampaignEnding extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $account;
    public $user;
    public $type; // 0 : User, 1 : Account Manager

    public function __construct($account, $user, $type)
    {
        $this->account = $account;
        $this->user = $user;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('INEX Digital Billboard Advertising')
            ->from('support@inex.net', "INEX Campaign Ending in 3 days")
            ->view('mail.CampEnding');
    }
}
