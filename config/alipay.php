<?php 
return [

    // 支付宝公钥
    'alipay_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqoIVFTdzPHbUkSjW5UKhj0MyQmxVxlbFKWfhPqAQcvUdG2n6eUehz2vCNQqIhqj81/H6WQ3SHO8yfJp5nBibiynjgSArMxdurEhIcwEvVLMW/EXb2V3rPXdZiP6+odVOvaH5u+udVPvaAaRuVcC+qQW1ELgFE/SGeHrlaATBC4+rS/RXkKZFBsMwx8P6+sQSErzqKoaC68uks/tdEoZbacLkqG2xk0ccsh/V5g8HDhrfNUCxaUbRwpbtXii3mipcdlPUVc6PUcVSm6XQzDapku+hRMuQO3DwrsyPr6SPZjhJi2ccx6o1DWHUoG9GGz8Qyj5Lbmzk26azVeIcP5JUKQIDAQAB',
    
    // 商户公钥
    'public_key' => '',

    // 商户私钥
    'private_key' => '...',

    // 商户app_id
    'app_id' => '2017091208684867',

    // 支付宝网关
    'gateway' => 'https://openapi.alipay.com/gateway.do',

    // 同步跳转
    'return_url' => "http://www.cool1024.com",

    // 异步通知地址
    'notify_url' => "http://www.cool1024.com",
];