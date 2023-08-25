<?php

namespace App\Sender;

use App\Models\Notification;
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

    public static function notification($user, $title, $message){
        Notification::create([
            "user" => $user,
            "title" => $title,
            "message" => $message,
            "status" => 1
        ]);
    }
}
