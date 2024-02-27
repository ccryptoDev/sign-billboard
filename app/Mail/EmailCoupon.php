<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailCoupon extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $coupon;
    public $accounter;
    public $type; // 0: Initial, 1 :  Refer

    public function __construct($user, $accounter, $coupon, $type)
    {
        $this->user = $user;
        $this->coupon = $coupon;
        $this->accounter = $accounter;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->type == 0?'INEX Coupon' : "INEX Referral Thank You")
            ->from('support@inex.net', "INEX Digital Billboard Advertising")
            ->view('mail.coupon');
    }
}
