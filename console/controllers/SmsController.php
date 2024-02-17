<?php

namespace console\controllers;

use common\models\Sms;
use common\helpers\SMSPilot;

use yii\console\Controller;

class SmsController extends Controller
{
    const ONE_TIME_SEND_SMS_COUNT = 20;

    public function actionIndex()
    {
        $smses = Sms::find()
            ->where(['status'=>Sms::STATUS_NOT_SEND])
            ->limit(self::ONE_TIME_SEND_SMS_COUNT)
            ->all();

        foreach ($smses as $sms){
            $smsPilot = new SMSPilot( 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ' );
            if ($smsPilot->send( '7'.$sms->phone, $sms->text)){
                $sms->status = Sms::STATUS_SEND;
                $sms->save();
                echo "SMS sent\n";
            }else{
                $sms->status = Sms::STATUS_ERROR;
                $sms->save();
                var_dump($smsPilot->error);
            }

        }

    }

}
