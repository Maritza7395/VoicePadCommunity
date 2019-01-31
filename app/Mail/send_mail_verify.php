<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class send_mail_verify extends Mailable
{
    use Queueable, SerializesModels;

    protected $datas;

    public function __construct($datas)
    {
        $this->datas = $datas;
    }

    public function build()
    {
        $address = 'admin@voicepadcommunity.me';
        $subject = 'Confirmar correo electronico';
        $name = 'Voicepad';

        return $this->view('mails.confirmation_code')
                    ->from($address, $name)
                    ->cc($address, $name)
                    ->bcc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([
                        'confirmation_code' => $this->datas['confirmation_code'],
                        'name' => $this->datas['name'],
                    ]);
    }
}
