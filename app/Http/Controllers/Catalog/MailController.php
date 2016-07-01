<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\UIComponents;

class MailController extends Controller
{
    public function index()
    {
        $input = \Request::all();

        if(isset($input['modal']) || isset($input['callMeBackWidget']) || isset($input['subscribeWidget'])){
            $transport = \Swift_SmtpTransport::newInstance('smtp.yandex.ru', 465, 'ssl');
            $transport->setUsername('new.goldenmotors@tut.by');
            $transport->setPassword('Gold3nMotors_2016');
            $yandex = new \Swift_Mailer($transport);

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

            if((isset($mail_data['phone']) && trim($mail_data['phone']) != '') || (isset($mail_data['email']) && trim($mail_data['email']) != '')){
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
                        $message->from('new.goldenmotors@tut.by', 'Автосалон Golden Motors');
                        $message->to('goldenmotors.by@gmail.com', 'Автосалон Golden Motors')->subject("Письмо с сайта [goldenmotors.by] - " .$mail_data['type']);
//                        $message->to('sislex@ya.ru', 'Автосалон Golden Motors')->subject("Письмо с сайта [goldenmotors.by] - " .$mail_data['type']);
                    });

                    return 'Письмо отправлено. Код: ' .$mail_sending_result;
                }
            }else{
                return 'Письмо не отправлено: не указаны контактные данные.';
            }
        }else{
            return 'Ошибка: нет данных для обработки.';
        }

//        $files = [
//            'logo' =>  public_path().'/images/ui-components/logo/'.UIComponents::getLogo(),
//            'logo_tpl' =>  '/images/ui-components/logo/'.UIComponents::getLogo(),
//        ];

//        $mailData['files'] = $files;
//        $mailData['type'] = 'mail';

//        \Mail::send('catalog.mail.index', $mailData, function($message)
        return 'Нераспознанная ошибка.';
    }

}
