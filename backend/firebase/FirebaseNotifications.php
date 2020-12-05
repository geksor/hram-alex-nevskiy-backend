<?php
namespace backend\firebase;

use yii\base\BaseObject;
use Yii;
use yii\helpers\ArrayHelper;
/**
 * @author Amr Alshroof
 */
class FirebaseNotifications extends BaseObject
{
    /**
     * @var string the auth_key Firebase cloude messageing server key.
     */
    public $authKey = 'AAAAQOFkBOI:APA91bG4uQAJD9Fu1K8ISPWKvFhVs5xS8ChhlZax7793gd75tQ76Nsi-LomwfzvCfS-SMyb6MvES0CVgTLLRVNfjUNy3ZQtbrk0BaHn1zijYiFThKYs1umURdDaV0xtyEY_Ut0-Y0phl';
    public $timeout = 5;
    public $sslVerifyHost = false;
    public $sslVerifyPeer = false;
    /**
     * @var string the api_url for Firebase cloude messageing.
     */
    public $apiUrl = 'https://fcm.googleapis.com/fcm/send';

    /**
     * @throws \Exception
     */
    public function init()
    {
        if (!$this->authKey) throw new \Exception("Empty authKey");
    }

    /**
     * send raw body to FCM
     * @param array $body
     * @return mixed
     * @throws \Exception
     */
    public function send($body)
    {
        $headers = [
            "Authorization:key={$this->authKey}",
            'Content-Type: application/json',
            'Expect: ',
        ];
        $ch = curl_init($this->apiUrl);
        curl_setopt_array($ch, array(
            CURLOPT_POST           => true,
            CURLOPT_SSL_VERIFYHOST => $this->sslVerifyHost,
            CURLOPT_SSL_VERIFYPEER => $this->sslVerifyPeer,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_FRESH_CONNECT  => false,
            CURLOPT_FORBID_REUSE   => false,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_POSTFIELDS     => json_encode($body),
        ));
        $result = curl_exec($ch);
        if ($result === false) {
            Yii::error('Curl failed: '.curl_error($ch).", with result=$result");
            throw new \Exception("Could not send notification. result= $result");
        }
        $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code<200 || $code>=300) {
            Yii::error("got unexpected response code $code with result=$result");
            throw new \Exception("Could not send notification. errorCode = $code ; result= $result");
        }
        curl_close($ch);
        $result = json_decode($result , true);
        return $result;
    }

    /**
     * @param string $to the registration ids
     * @param array $notification can be something like {title:, body:, sound:, badge:, click_action:, }
     * @param array $data
     * @param array $ids
     * @return mixed
     * @throws \Exception
     */
    public function sendNotification($to, $notification, $data, $ids = null)
    {
        if ($ids){
            $toKey = 'registration_ids';
            $toValue = $ids;
        }else{
            $toKey = 'to';
            $toValue = $to;
        }

        if ($notification){
            $body = [
                $toKey => $toValue,
                'notification' => $notification,
                'data' => $data,
            ];
        } else {
            $body = [
                'to' => $to,
                'data' => $data,
            ];
        }

        return $this->send($body);
    }
}