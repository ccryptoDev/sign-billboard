<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EndCampNotification extends Mailable
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
        $today = date("Y-m-d");
        return $this->subject('INEX Digital Billboard Advertising')
            ->from('support@inex.net', $today == $this->campaign->end_date?"Your Campaign is ended":"Your Campaign will be expired in a week")
            ->view('mail.user-camp-end');
    }
}
