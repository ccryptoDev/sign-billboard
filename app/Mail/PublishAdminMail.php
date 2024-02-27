<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PublishAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $ads;
    
    public function __construct($user, $ads)
    {
        $this->user = $user;
        $this->ads = $ads;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('INEX Digital Billboard Advertising')
                    ->from('support@inex.net', 'New Ads are deliveried to CM')
                    ->view('mail.publish');
    }
}
