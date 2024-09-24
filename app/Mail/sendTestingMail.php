<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendTestingMail extends Mailable
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
    public function __construct()
    {
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $e_otp= '';
        $e_subject='';
        $tcPassword='';
        $email='';
   
        return $this->view('mail.testing',compact("tcPassword","email"))->subject($e_subject)->with(['data' => []]);
        return back();
    }
}
