<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncidentExpiry extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $getsubject;
    public $getMessage;
    public function __construct($subject,$message)
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
        $expiryMail=$this->getMessage;
   
        return $this->view('mail.incidentExpiry',compact("expiryMail"))->subject($e_subject);
        return back();
    }
}