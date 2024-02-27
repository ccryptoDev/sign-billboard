<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TextSuggest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $suggest;

    public function __construct($suggest)
    {
        $this->suggest = $suggest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Check for New INEX Suggestion')
            ->from('support@inex.net', 'INEX Digital Billboard Advertising')
            ->view('mail.textSuggest');
    }
}
