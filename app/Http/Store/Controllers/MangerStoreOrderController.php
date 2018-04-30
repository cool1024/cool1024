<?php

/**
 * 订单管理控制器
 * 
 * @file   MangerStoreOrderController.php
 * @author xiaojian
 * @date   2018-04-27
 */
namespace App\Http\Store\Controllers;

use App\Http\Store\Models\StoreOrder;

class MangerStoreOrderController extends Controller
{

    /**
     * 订单列表-分页
     */
    public function searchOrder()
    {
        $required = [
            'limit:integer',
            'offset:integer',
        ];

        $expected = [
            'start:date',
            'end:date',
            'sn:max:45',
            'consignee:max:45',
            'status:integer',
        ];

        $params = $this->api->camelCaseParams($required, $expected);

        $search_params = [
            ['with', ['user', 'goodsList']],
            ['whereDate', 'created_at', '>=', '$start'],
            ['whereDate', 'created_at', '<=', '$end'],
            ['where', 'order_sn', 'like', '$sn'],
            ['where', 'consignee', 'like', '$consignee'],
            ['where', 'order_status', '$status'],
        ];

        $search_formats = [
            'sn' => '%$sn%',
            'consignee' => '%$consignee%',
        ];

        $search_result = with(new StoreOrder)->search($params, $search_params, $search_formats);
        return $this->api->searchMessage($search_result);
    }

    /**
     * 获取订单详情
     */
    public function getOrder()
    {
        $required = [
            'order_id:integer',
        ];

        $params = $this->api->camelCaseParams($required);

        $order = StoreOrder::with(['user', 'goodsList'])->findOrFail($params['order_id']);

        return $this->api->getMessage($order);
    }
}
