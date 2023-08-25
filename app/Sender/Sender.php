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

    public static function sms($to, $message){
        $number = '90'.$to;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://smsgw.mutlucell.com/smsgw-ws/sndblkex',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'<?xml version="1.0" encoding="UTF-8"?>
        <smspack ka="akbiltek" pwd="passAA@2023" org="AKBILSOFT">
            <mesaj>
                <metin>'.$message.'</metin>
                <nums>'.$number.'</nums>
            </mesaj>
        </smspack>',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: text/xml'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        if($response){
            return response($response);
        }

    }
}
