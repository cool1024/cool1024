<?php

namespace App\Sdk;

class ApiToken
{

    private $appId;
    private $publicKey;
    private $appSecret;

    public function __construct()
    {
        $this->appId = env('API_APP_ID');
        $this->publicKey = env('API_PUBLIC_KEY');
        $this->publicKey = file_get_contents($this->publicKey);
        $this->appSecret = env('API_SECRET');
    }

    public function getApiData($serviceKey)
    {
        $data = [
            'params' => [
                'timestamp' => time(),
                'random' => str_random(10)
            ],
            'sign' => '',
            'service_key' => $serviceKey,
            'app_id' => $this->appId
        ];
        $data['params'] = base64_encode(json_encode($data['params']));
        $publicKey = openssl_pkey_get_public($this->publicKey);
        openssl_public_encrypt($data['params'], $data['params'], $publicKey);
        $data['params'] = base64_encode($data['params']);
        $data['sign'] = md5($data['params'] . $this->appSecret);
        return base64_encode(json_encode($data));
    }
}
