<?php

namespace App\Notifications;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use App\Models\Sms_log;

class SendSms extends Notification
{
    public function toSms($mobile, $body)
    {
        $url = config('services.bangladeshsms.domain');
        // $encodedMessage = urlencode($body);
        $apiKey = config('services.bangladeshsms.api_key');
        $senderId = config('services.bangladeshsms.senderid');

        $data = [
            "url"=>$url,
            "user_id"=>Auth::id(),
            "api_key" => $apiKey,
            "type" => "text",
            "contacts" => $mobile,
            "senderid" => $senderId,
            "label" => 'transactional',
            "msg" => $body
        ];

        try{
            $smslog = new Sms_log();
            $smslog->fill($data)->save();
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
            
            $update = ["response"=>$response];
            $smslog->update($update);

        }catch(\Exception $e) {
            flash()->addError($e);
        }
    }
}
