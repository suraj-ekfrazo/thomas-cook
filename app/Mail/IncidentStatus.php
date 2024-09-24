<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncidentStatus extends Mailable
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
        $agentMessage=$this->getMessage;
   
        return $this->view('mail.incidentStatusMail',compact("agentMessage"))->subject($e_subject);
        return back();
    }
}
