<?php

namespace Webkul\Vapulus\Helpers;

class Helper {

    public function getCurrencies()
    {
        $currencies = [];

        $channel_currencies = core()->getCurrentChannel()->currencies;
        foreach($channel_currencies as $currency) {
            $currencies[$currency->code] = $currency->name;
        }

        return $currencies;
    }

    public function generateHash($hashSecret, $postData) {
        ksort($postData);
        $message = "";
        $appendAmp = 0;

        foreach($postData as $key => $value) {
            if (strlen($value) > 0) {
                if ($appendAmp == 0) {
                    $message .= $key . '=' . $value;
                    $appendAmp = 1;
                } else {
                    $message .= '&' . $key . "=" . $value;
                }
            }
        }
    
        $secret = pack('H*', $hashSecret);

        return hash_hmac('sha256', $message, $secret);
    }

    public function HTTPPost($api, array $params) {

        $url = 'https://api.vapulus.com:1338/' . $api;

        $query = http_build_query($params);
        $ch    = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}