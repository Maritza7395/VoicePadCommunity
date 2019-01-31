<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewAdministratorN extends Mailable
{
   use Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $address = 'admin@voicepadcommunity.me';
        $subject = 'Administrador de VoicepadCommunity';
        $name = 'Voicepad Community';

        return $this->view('mails.newAdministrator')
                    ->from($address, $name)
                    ->cc($address, $name)
                    ->bcc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([
                        'text' => $this->data['message'],
                        'url' => $this->data['url'],
                    ]);
    }
}
