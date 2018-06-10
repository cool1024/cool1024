<?php
//-----------------------------------------------------
// 2018-01-12 15:20:51
// author xiaojian
//-----------------------------------------------------

namespace App\Sdk;

class WechatPay
{

    private $app_id;
    private $mch_id;
    private $secret_key;
    private $notify_url;
    private $return_url;
    private $pre_pay;

    public function __construct($config)
    {
        $this->app_id = $config['app_id'];
        $this->mch_id = $config['mch_id'];
        $this->secret_key = $config['secret'];
        $this->notify_url = $config['notify_url'];
        $this->return_url = $config['return_url'];
        $this->pre_pay_url = $config['pre_pay_url'];
    }

    /**
     * 用户订单信息生成--APP
     * @param int $price 订单价格（单位：分）
     * @param int $title 支付标题
     * @param string $body 支付说明文字
     * @param string $ordersn 订单号（我们的）
     * @return array 订单支付数据
     */
    public function initAppOrderData($price, $title, $body, $ordersn)
    {
        return $this->initOrderData($price, $title, $body, $ordersn, 'APP');
    }

    /**
     * 用户订单信息生成--小程序
     * @param int $price 订单价格（单位：分）
     * @param int $title 支付标题
     * @param string $body 支付说明文字
     * @param string $ordersn 订单号（我们的）
     * @param string $openid 下单用户的openid
     * @return array 订单支付数据
     */
    public function initSmallRoutineOrderData($price, $title, $body, $ordersn, $openid)
    {
        $pay_array = [];
        //生成预支付交易单的必选参数:
        $newPara = array();
        //应用ID
        $newPara["appid"] = $this->app_id;
        //商户号
        $newPara["mch_id"] = $this->mch_id;
        //设备号
        $newPara["device_info"] = "WEB";
        //随机字符串
        $newPara["nonce_str"] = $this->get_rand_key() . uniqid();
        //商品描述
        $newPara["body"] = $body;
        //商户订单号
        $newPara["out_trade_no"] = $ordersn;
        //总金额
        $newPara["total_fee"] = $price;
        //终端IP
        $newPara["spbill_create_ip"] = $_SERVER["REMOTE_ADDR"];
        //通知地址
        $newPara["notify_url"] = $this->notify_url;
        //交易类型
        $newPara["trade_type"] = 'JSAPI';
        $newPara["openid"] = $openid;        
        //签名
        $newPara["sign"] = $this->produce_wechat_sign($newPara);
        //传参
        $xmlData = $this->get_wechat_xml($newPara);
        //统一下单接口返回正常的prepay_id，再按签名规范重新生成签名后，将数据传输给APP
        $get_data = $this->send_pre_pay_curl($xmlData);
        //如果确认支付正确
        if ($get_data['return_code'] == "SUCCESS" && $get_data['result_code'] == "SUCCESS") {
            $newPara["nonce_str"] = $this->get_rand_key() . uniqid();
            $newPara['timeStamp'] = time() . "";
            $secondSignArray = array(
                "appId" => $newPara['appid'],
                "nonceStr" => $newPara['nonce_str'],
                "package" => "prepay_id=" . $get_data['prepay_id'],
                "timeStamp" => $newPara['timeStamp'],
                "signType" => "MD5"
            );
            $pay_array['sign_array'] = $secondSignArray;
            $pay_array['ordersn'] = $newPara["out_trade_no"];
            $pay_array['sign_array']['paySign'] = $this->produce_wechat_sign($secondSignArray);
            return $pay_array;
        }
        return 'sign error';
    }

    private function initOrderData($price, $title, $body, $ordersn, $trade_type, $openid = '')
    {
        $pay_array = [];
        //生成预支付交易单的必选参数:
        $newPara = array();
        //应用ID
        $newPara["appid"] = $this->app_id;
        //商户号
        $newPara["mch_id"] = $this->mch_id;
        //设备号
        $newPara["device_info"] = "WEB";
        //随机字符串
        $newPara["nonce_str"] = $this->get_rand_key() . uniqid();
        //商品描述
        $newPara["body"] = $body;
        //商户订单号
        $newPara["out_trade_no"] = $ordersn;
        //总金额
        $newPara["total_fee"] = $price;
        //终端IP
        $newPara["spbill_create_ip"] = $_SERVER["REMOTE_ADDR"];
        //通知地址
        $newPara["notify_url"] = $this->notify_url;
        //交易类型
        $newPara["trade_type"] = $trade_type;
        //签名
        $newPara["sign"] = $this->produce_wechat_sign($newPara);
        //传参
        $xmlData = $this->get_wechat_xml($newPara);
        //统一下单接口返回正常的prepay_id，再按签名规范重新生成签名后，将数据传输给APP
        $get_data = $this->send_pre_pay_curl($xmlData);
        //如果确认支付正确
        if ($get_data['return_code'] == "SUCCESS" && $get_data['result_code'] == "SUCCESS") {
            //微信支付，返回prepayid给我
            $newPara["nonce_str"] = $this->get_rand_key() . uniqid();
            $newPara['timeStamp'] = time() . "";
            $secondSignArray = array(
                "appid" => $newPara['appid'],
                "noncestr" => $newPara['nonce_str'],
                "package" => "Sign=WXPay",
                "prepayid" => $get_data['prepay_id'],
                "partnerid" => $newPara['mch_id'],
                "timestamp" => $newPara['timeStamp'],
            );
            $pay_array['sign_array'] = $secondSignArray;
            $pay_array['ordersn'] = $newPara["out_trade_no"];
            $pay_array['sign_array']['sign'] = $this->wechat_second_sign($newPara, $get_data['prepay_id']);
            return $pay_array;
        }
        return 'sign error';
    }

    /**
     * 异步通知验证
     * @param string $xmldata
     * @return array [result:boolean,message:string,datas:array]
     */
    public function notifyCheck($xmldata)
    {
        $return_datas = [
            //验签结果
            'result' => false,
            //提示消息
            'message' => '',
            //可用参数
            'datas' => array(),
        ];
        //解析xmldata
        $postObj = simplexml_load_string($xmldata, 'SimpleXMLElement', LIBXML_NOCDATA);
        $obj = json_decode(json_encode($postObj));
        //file_put_contents("/home/infoback.txt", '订单号'.$obj->out_trade_no.':', FILE_APPEND);
        //判断是否收到通信标识
        if ($obj->return_code == "SUCCESS" && $obj->result_code == "SUCCESS") {
            $get_data = array(
                'appid' => $obj->appid,
                'bank_type' => $obj->bank_type,
                'cash_fee' => $obj->cash_fee,
                'device_info' => $obj->device_info,
                'fee_type' => $obj->fee_type,
                'is_subscribe' => $obj->is_subscribe,
                'mch_id' => $obj->mch_id,
                'nonce_str' => $obj->nonce_str,
                'openid' => $obj->openid,
                'out_trade_no' => $obj->out_trade_no,
                'result_code' => $obj->result_code,
                'return_code' => $obj->return_code,
                'time_end' => $obj->time_end,
                'total_fee' => $obj->total_fee,
                'trade_type' => $obj->trade_type,
                'transaction_id' => $obj->transaction_id,
                'sign' => $obj->sign,
            );
            if ($get_data['sign'] == $this->notify_sign_verification($get_data)) {
                $return_datas['datas'] = $get_data;
                $return_datas['result'] = true;
            } else {
                $return_datas['message'] = "验签失败";
            }
        } else {
            $return_datas['message'] = "支付失败-业务/相应状态错误";
        }
        return $return_datas;
    }

    /**
     * 订单查询
     * @param string $ordersn 我们的订单号
     * @return array 订单数据
     */
    public function findOrder($ordersn)
    {
        $newPara["appid"] = $this->app_id;
        $newPara["mch_id"] = $this->mch_id;
        $newPara["out_trade_no"] = $ordersn;
        $newPara["nonce_str"] = $this->get_rand_key() . uniqid();
        $newPara["sign_type"] = "MD5";
        $newPara["sign"] = $newPara["sign"] = $this->produce_wechat_sign($newPara);
        $xml_data = $this->get_wechat_xml($newPara);
        $return_datas = $this->send_post_curl("https://api.mch.weixin.qq.com/pay/orderquery", $xml_data);
        return $return_datas;
    }

    private function send_pre_pay_curl($xml_data)
    {
        $url = $this->pre_pay_url;
        $header[] = "Content-type: text/xml";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml_data);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            print curl_error($curl);
        }
        curl_close($curl);
        return $this->xml_data_parse($data);
    }

    private function send_post_curl($url, $xml_data)
    {
        $header[] = "Content-type: text/xml";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml_data);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            print curl_error($curl);
        }
        curl_close($curl);
        return $this->xml_data_parse($data);
    }

    private function xml_data_parse($data)
    {
        $msg = array();
        $msg = (array)simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
        return $msg;
    }
    private function get_rand_key()
    {
        $string = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';
        $cdkey = "";
        for ($i = 0; $i < 3; $i++) {
            $cdkey .= $string[rand(0, strlen($string) - 1)];
        }
        return $cdkey;
    }

    public function produce_wechat_sign($new_para)
    {
        $stringA = $this->get_sign_content($new_para);
        $stringSignTemp = $stringA . "&key={$this->secret_key}";
        return strtoupper(MD5($stringSignTemp));
    }

    private function wechat_second_sign($newPara, $prepay_id)
    {
        $secondSignArray = array(
            "appid" => $newPara['appid'],
            "noncestr" => $newPara['nonce_str'],
            "package" => "Sign=WXPay",
            "prepayid" => $prepay_id,
            "partnerid" => $newPara['mch_id'],
            "timestamp" => $newPara['timeStamp'],
        );
        $stringA = self::get_sign_content($secondSignArray);
        $stringSignTemp = $stringA . "&key={$this->secret_key}";
        return strtoupper(MD5($stringSignTemp));
    }

    private function get_sign_content($params)
    {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->check_empty($v) && "@" != substr($v, 0, 1)) {
                $v = $this->characet($v, 'UTF-8');
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset($k, $v);
        return $stringToBeSigned;
    }

    private function check_empty($value)
    {
        if (!isset($value)) return true;
        if ($value === null) return true;
        if (trim($value) === "") return true;
        return false;
    }

    private function characet($data, $targetCharset)
    {
        if (!empty($data)) {
            $fileType = 'UTF-8';
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }
        return $data;
    }

    public static function get_wechat_xml($newPara)
    {
        $xmlData = "<xml>";
        foreach ($newPara as $key => $value) {
            $xmlData = $xmlData . "<" . $key . ">" . $value . "</" . $key . ">";
        }
        $xmlData = $xmlData . "</xml>";
        return $xmlData;
    }

    public function notify_sign_verification($array)
    {
        $new = $array;
        unset($new['sign']);
        $stringA = $this->get_sign_content($new);
        $stringSignTemp = $stringA . "&key={$this->secret_key}";
        return strtoupper(MD5($stringSignTemp));
    }
}