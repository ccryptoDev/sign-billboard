<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $campaign;
    public $flag;
    public $locations;


    public function __construct($user, $campaign, $flag, $locations)
    {
        $this->user = $user;
        $this->campaign = $campaign;
        $this->flag = $flag;
        $this->locations = $locations;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->flag == 0?'INEX New Campaign Confirmation':'INEX Update Campaign Confirmation')
            ->from('support@inex.net', 'INEX Digital Billboard Advertising')
            ->view('mail.user-camp');

    }
}
