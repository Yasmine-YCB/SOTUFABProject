<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body;
    public $fromAddress;
    public $Message_from ;

    public function __construct($subject, $body,$fromAddress, $Message_from )
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->fromAddress = $fromAddress;
        $this->Message_from = $Message_from;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->fromAddress)
                    ->subject($this->subject)
                    ->markdown('emails.contact')
                    ->with(['body' =>  $this->body ])
                    ->with(['from' => $this->Message_from ]);
    }
}
