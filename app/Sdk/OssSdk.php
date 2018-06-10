<?php

/**
 * OSS上传
 * @file OssSdk.php
 * @author xiaojian
 * @date 2018-06-10
 */

namespace App\Sdk;

class OssSdk
{
    private $oss_id;
    private $oss_key;
    private $oss_host;

    /**
     * 构造函数
     * @param string $oss_id
     * @param string $oss_key
     * @param string $oss_host
     */

    public function __construct($oss_id, $oss_key, $oss_host)
    {
        $this->oss_id = $oss_id;
        $this->oss_key = $oss_key;
        $this->oss_host = $oss_host;
    }

    /** 
     * 获取上传授权链接
     * @param int $size 文件大小（1024为1K）
     * @param int $time 有效时间（分钟）
     * @param string $dir 文件保存路径
     * @return  string
     */
    public function getAccessDatas($size = 10240000, $time = 10, $dir = 'upload')
    {
        $id = $this->oss_id;
        $key = $this->oss_key;
        $host = $this->oss_host;

        $now = time();
        $expire = $time; //设置该policy超时时间是$time. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $expire;
        $expiration = $this->gmt_iso8601($end);

        //最大文件大小.用户可以自己设置
        $condition = array(0 => 'content-length-range', 1 => 0, 2 => $size);
        $conditions[] = $condition; 

        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = array(0 => 'starts-with', 1 => '$key', 2 => $dir);
        $conditions[] = $start;


        $arr = array('expiration' => $expiration, 'conditions' => $conditions);

        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

        $response = array();
        $response['accessid'] = $id;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;
        return $response;
    }

    /**
     * 时间串格式化-获取失效时间串
     * @param string $time 时间串
     * @return string
     */
    private function gmt_iso8601($time)
    {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration . "Z";
    }
}
