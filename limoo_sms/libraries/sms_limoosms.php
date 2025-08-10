<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sms_limoosms extends App_sms
{
    private $token;
    private $from;

    public function __construct()
    {
        parent::__construct();

        $this->token = $this->get_option('limoosms', 'token');
        $this->from     = $this->get_option('limoosms', 'from');

        $this->add_gateway('limoosms', [
            'name'    => 'limoosms',
            'info'    => '<p>برای استفاده از سامانه لیمو اس‌ام‌اس نیاز به نام کاربری و رمز عبور پنل کاربری خود دارید.</p><hr class="hr-10" />',
            'options' => [
                [
                    'name'  => 'token',
                    'label' => 'کد توکن دسترسی',
                ],
                [
                    'name'  => 'from',
                    'label' => 'شماره فرستنده',
                ],
            ],
        ]);
    }

    public function send($number, $message)
    {
        $url = 'https://api.limosms.com/api/sendsms';
        $receiver = array($number);

        $post_data = json_encode(array(
            'Message' =>$message ,
            'SenderNumber' => $this->from,
            'MobileNumber' => $receiver,
            ));

        $headers = array('Content-Type: application/json'
            ,'ApiKey:' . $this->token);

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL,$url);
        curl_setopt( $ch, CURLOPT_TIMEOUT,30);
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $err      = curl_error($ch);

        curl_close($ch);

        if ($err) {
            $this->set_error($err);
            return false;
        }

        $result = json_decode($response, true);

        if (isset($result['success']) && $result['success'] == 1) {
            $this->logSuccess($number, $message);
            return true;
        } else {
            $errorMessage = isset($result['message']) ? $result['message'] : 'ارسال پیامک ناموفق بود';
            $this->set_error($errorMessage);
            return false;
        }
    }
}
