<?php

namespace celusion\smsconnexion;

use Yii;
use yii\base\InvalidConfigException;
use GuzzleHttp\Client;
use yii\base\InvalidParamException;

class SMSConneXion{
    /**
     * Sends an SMS message (string) to the specified mobile number (string)
     * @return bool Successfully queued by SMSConneXion
     * @throws InvalidParamException if the `$smsconnexionusername` or `$smsconnexionpassword` parameter is not specified in params
     */
    public static function sendSMS($phone,$message)
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://smsc.smsconnexion.com/api',
        ]);
        if (!isset(Yii::$app->params['smsconnexionusername']) || ! isset(Yii::$app->params['smsconnexionpassword'])){
            throw new InvalidParamException('Both the username and password you got from SMSConneXion.com must be specified in smsconnexionusername and smsconnexionpassword params in your config');
        }
        $smsusername = Yii::$app->params['smsconnexionusername'];
        $smspassword = Yii::$app->params['smsconnexionpassword'];
        $response = $client->get('http://smsc.smsconnexion.com/api/gateway.aspx',
            ['query'=>
                [
                    'action'=>'send'
                    ,'username'=>$smsusername
                    ,'passphrase'=>$smspassword
                    ,'phone'=>$phone
                    ,'message'=>$message
                ]
            ]);
        $body = $response->getBody(true);
        $myArray = explode(',', $body);
        $c = count($myArray);
        if ($c > 0){
            //We found comma separated
            //Get the first
            //Check if it is 0 or 1
            $success = reset($myArray);
            if ($success == '1'){
                return true;
            }
            throw new ServerErrorHttpException('Non-empty respnse, NON success' . $body);
        }
        throw new ServerErrorHttpException('Less than zero count array response!' . $body);
        return false;
    }

}
