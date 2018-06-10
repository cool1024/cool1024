<?php

/**
 * 身份证识别
 * @file IdCardReader.php
 * @author xiaojian
 * @date 2018-06-10
 */
namespace App\Sdk;

class IdCardReader
{
    private $appKey;

    private $appCode;

    private $apiUrl;

    /**
     * 构造函数
     * 
     * @param string $appKey
     * @param string $appCode
     */
    public function __construct($appKey, $appCode)
    {
        $this->appKey = $appKey;
        $this->appCode = $appCode;
        $this->apiUrl = 'http://dm-51.data.aliyun.com/rest/160601/ocr/ocr_idcard.json';
    }

    /**
     * 识别base64图片（不能带type之类的格式，必须时一个干净的图片数据）
     * 
     * @param string $base64
     * @param string $side face|back
     * @return array|bool 识别结果，如果返回为false那么识别失败，如果返回array，需要自行判断是否识别成功
     */
    public function readBase64($base64, $side = 'face')
    {
        $config = ['side' => $side];
        $body = [
            'image' => $base64,
            'configure' => json_encode($config),
        ];
        return $this->sendRequest($body);
    }

    /**
     * 识别本地图片
     * 
     * @param string $file 文件路径
     * @param string $side face|back
     * @return array|bool 识别结果，如果返回为false那么识别失败，如果返回array，需要自行判断是否识别成功
     */
    public function readFile($file, $side = 'face')
    {
        // 读取文件转base64
        if ($fp = fopen($file, "rb", 0)) {
            $binary = fread($fp, filesize($file));
            fclose($fp);
            $base64 = base64_encode($binary);
            return $this->readBase64($base64, $side);
        } else {
            return false;
        }
    }

    /**
     * 发送api请求
     * 
     * @param array $body 请求参数
     * @return array|boolean
     */
    private function sendRequest($body)
    {
        $headers = [
            'Authorization:APPCODE ' . $this->appCode,
            "Content-Type" . ":" . "application/json; charset=UTF-8"
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->apiUrl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        $result = json_decode($result, true);
        return $result === null ? false : $result;
    }
}