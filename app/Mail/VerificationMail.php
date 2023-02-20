<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data=[];
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function build()
    {
        $mailData['code'] = $this->data["code"];
        return $this->from('shieldz.co@gmail.com', 'Testing')
                    ->subject($this->data["subject"])
                    ->view('mail.verify_mail' , $mailData)
                    ->with("data",$this->data);
    }
}
