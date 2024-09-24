<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class createIncidentSuccess extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $getsubject;
    public $getMessage;
    public function __construct($subject,$data)
    {
        $this->getsubject=$subject;
        $this->getMessage=$message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $e_subject=$this->getsubject;
        $message=$this->getMessage;
   
        return $this->view('mail.incidentCreateMail',compact("message"))->subject($e_subject);
        return back();
    }
}
