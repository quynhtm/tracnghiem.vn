<?php

namespace App\Http\Controllers;

use App\Mail\MailSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class MailSendController extends Controller
{
    public function sentEmail(){
        $email = 'quynhtm@peacesoft.net';
        $name = 'Quynhtesst';
        $password_new = 'passs';
        $subject ='xem gui dc chua';
        $abc = Mail::send('mail.mailForgotPassword', ['name' => $name, 'password_new' => trim($password_new)],
            function ($mail) use ($email, $name, $subject) {
                $mail->from(env('MAIL_USERNAME','manhquynh1984@gmail.com'), $subject);
                $mail->to($email, $name);
                $mail->subject($subject.' '.getCurrentDateTime());
            });
        vmDebug($abc);

        /*$abc = Mail::to('quynhtm@peacesoft.net')->send(new MailSystem());
        vmDebug($abc);*/
    }
}
