<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $getcode;
    public $getsubject;
    public function __construct($code,$subject)
    {
        $this->getcode=$code;
        $this->getsubject=$subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $e_otp=$this->getcode;
        $e_subject=$this->getsubject;
   
        return $this->view('mail.sendemail',compact("e_otp"))->subject($e_subject);
        return back();
    }
}
