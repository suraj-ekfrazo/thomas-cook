<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendTcViewMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $getcode;
    public $getsubject;
    public $getpassword;
    public function __construct($code,$subject,$password)
    {
        $this->getcode= $code;
        $this->getsubject=$subject;
        $this->getpassword=$password;
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
        $tcPassword=$this->getpassword;
        $email=$e_otp['admin_email'];
   
        return $this->view('mail.tcViewDetailsMail',compact("tcPassword","email"))->subject($e_subject)->with(['data' => $this->getcode]);
        return back();
    }
}
