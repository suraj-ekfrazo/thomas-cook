<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncidentUpdateStatus extends Mailable
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
        $incidentAprroved=$this->getMessage;
   
        return $this->view('mail.incidentUpdateStatusMail',compact("incidentAprroved"))->subject($e_subject);
        return back();
    }
}
