<?php

use App\Api\Contracts\FormContract;
use App\Sdk\WechatPay;

// 微信支付

$router->get('wechat/pay', function (FormContract $form) {

    $wechat = new WechatPay([
        'app_id' => '',
        'mch_id' => '',
        'secret' => '',
        'notify_url' => 'https://www.cool1024.com',
        'return_url' => '',
        'pre_pay_url' => 'https://api.mch.weixin.qq.com/pay/unifiedorder',
    ]);

    // 订单号，不能重复
    $orderSn = date('YMdHis');

    $orderData = $wechat->initAppOrderData(1, '微信支付', '卖货郎-测试订单', $orderSn);

    // 800k设置
    return $form->success($orderData);
});
