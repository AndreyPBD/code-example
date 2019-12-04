<?php

declare(strict_types=1);

namespace App\Util;

use Illuminate\Support\Facades\Mail;

class Mailer
{
    public function sendEmail($recipient, $code)
    {
        $data = [
            'email'=> $recipient,
            'code' => $code
        ];

        Mail::send('emails.invitation', $data, static function($message) use ($recipient) {
            $message->to($recipient)
                ->subject('Registration in CRBRS App');
            $message->from(env('MAIL_USERNAME'), 'CRBRS App [no-reply]');
        });
    }
}
