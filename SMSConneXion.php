<?php

namespace celusion\smsconnexion;

class SMSConneXion{
    /**
     * Sends an SMS message (string) to the specified mobile number (string)
     * @return bool Successfully queued by SMSConneXion
     */
    public static function sendSMS($phone,$message)
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://smsc.smsconnexion.com/api',
        ]);
        $response = $client->get('http://smsc.smsconnexion.com/api/gateway.aspx',
            ['query'=>
                [
                    'action'=>'send'
                    ,'username'=>static::SMS_USERNAME
                    ,'passphrase'=>static::SMS_PASSWORD
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
