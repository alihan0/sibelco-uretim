<?php

namespace App\Sender;

use Illuminate\Support\Facades\Mail;

class Sender
{
    public static function email($to, $subject, $data, $template)
{
    Mail::send($template, $data, function ($email) use ($to, $subject) {
        $email->to($to);
        $email->subject($subject);
    });
}
}
