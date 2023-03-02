<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data=[];
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function build()
    {
        $mailData['code'] = $this->data['code'];
        $mailData['email'] = $this->data['email'];
        return $this->from('noreply@qrcode.co.ke', 'Global Technologies Ltd')
                    ->subject($this->data["subject"])
                    ->view('mail.password_reset_mail' , $mailData)
                    ->with("data",$this->data);
    }
}
