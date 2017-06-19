<?php

namespace App\Http\Controllers\Catalog;

use App\Email;
use App\Http\Controllers\Controller;
use App\SMTP;
use App\UIComponents;

class MailController extends Controller
{
    public function index()
    {
        $input = \Request::all();

        if(isset($input['modal']) || isset($input['callMeBackWidget']) || isset($input['subscribeWidget'])){

            $smtp = SMTP::all()->first();

            $transport = \Swift_SmtpTransport::newInstance($smtp->server, $smtp->port, $smtp->security);
            $transport->setUsername($smtp->login);
            $transport->setPassword($smtp->password);
            $yandex = new \Swift_Mailer($transport);

//            $transport = \Swift_SmtpTransport::newInstance('smtp.yandex.ru', 465, 'ssl');
//            $transport->setUsername('new.goldenmotors@tut.by');
//            $transport->setPassword('Gold3nMotors_2016');
//            $yandex = new \Swift_Mailer($transport);

            \Mail::setSwiftMailer($yandex);

            if(isset($input['modal'])){
                $mail_data = $input['modal'];
            }

            if(isset($input['callMeBackWidget'])){
                $mail_data = $input['callMeBackWidget'];
            }

            if(isset($input['subscribeWidget'])){
                $mail_data = $input['subscribeWidget'];
            }

            if(isset($mail_data['friend']) && trim($mail_data['friend'] != '')){
                $mail_sending_result = \Mail::send('catalog.mail.tpl2-share-with-friend', ['mail_data' => $mail_data], function($message) use ($mail_data)
                {
                    $message->from('new.goldenmotors@tut.by', 'Автосалон Golden Motors');
                    $message->to($mail_data['friend'])->subject("Письмо с сайта [goldenmotors.by]");
                });

                return 'Письмо отправлено. Код: ' .$mail_sending_result;

            } else {
                $mail_sending_result = \Mail::send('catalog.mail.tpl1-general', ['mail_data' => $mail_data], function($message) use ($mail_data)
                {
                    $send_email_to = Email::getEmail();
                    $send_email_from = SMTP::all()->first()->login;
                    $message->from($send_email_from, 'Автосалон Golden Motors');
                    $message->to($send_email_to, 'Автосалон Golden Motors')->subject("Письмо с сайта [goldenmotors.by] - " .$mail_data['type']);

                });

                dd($mail_sending_result);

                return 'Письмо отправлено. Код: ' .$mail_sending_result;
            }
        }else{
            return 'Ошибка: нет данных для обработки.';
        }

        return 'Нераспознанная ошибка.';
    }
}
