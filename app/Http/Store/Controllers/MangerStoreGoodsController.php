<?php

/**
 * 商品管理控制器
 * 
 * @file   MangerStoreGoodsController.php
 * @author xiaojian
 * @date   2018-04-27
 */
namespace App\Http\Store\Controllers;

use App\Http\Store\Models\StoreGoods;
use App\Http\Store\Models\StoreGoodsType;
use App\Http\Store\Models\StoreGoodsSpecification;
use App\Http\Store\Models\StoreGoodsSpecificationDetail;

class MangerStoreGoodsController extends Controller
{

    /**
     * 商品列表-分页
     */
    public function searchGoods()
    {
        $required = [
            'limit:integer',
            'offset:integer',
        ];

        $expected = [
            'name:date',
            'end:date',
            'sn:max:45',
        ];

        $params = $this->api->camelCaseParams($required, $expected);

        $search_params = [
            ['whereDate', 'created_at', '>=', '$start'],
            ['whereDate', 'created_at', '<=', '$end'],
            ['where', 'goods_name', 'like', '$name'],
        ];

        $search_formats = [
            'name' => '%$name%',
        ];

        $search_result = with(new StoreGoods)->search($params, $search_params, $search_formats);
        return $this->api->searchMessage($search_result);
    }

    /**
     * 获取商品详情
     */
    public function getGoods()
    {
        $required = [
            'goods_id:integer',
        ];
        $params = $this->api->camelCaseParams($required);

        $goods = StoreGoods::findOrFail($params['goods_id']);
        $goods->goods_parent_type = StoreGoodsType::findOrFail($goods->goods_type)->parent_id;

        $datas = [
            'goods' => $goods,
            'goodsSpecifications' => [],
            'goodsSpecificationDetails' => []
        ];

        $specifications = StoreGoodsSpecification::where('goods_id', $goods->id)->get();
        foreach ($specifications as $specification) {
            $datas['goodsSpecifications'][] = [
                'specificationTitle' => $specification->specification_title,
                'specificationNames' => unserialize($specification->specification_names),
            ];
        }

        $specification_details = StoreGoodsSpecificationDetail::where('goods_id', $goods->id)->get();
        foreach ($specification_details as $detail) {
            $datas['goodsSpecificationDetail'][] = [
                'specificationTitleIndexs' => unserialize($detail->specification_title_indexs),
                'specificationTitles' => unserialize($detail->specification_titles),
                'goodsPrice' => $detail->goods_price,
                'goodsStocks' => $detail->goods_stocks,
                'isActive' => $detail->is_active,
            ];
        }

        return $this->api->getMessage($datas);
    }

    /**
     * 获取商品类型下拉选项
     */
    public function getGoodsTypeOptions()
    {
        $options = [
            'parentTypes' => StoreGoodsType::select('id as value', 'goods_type_title as text')
                ->where('parent_id', 0)->get(),
            'childTypes' => StoreGoodsType::select('id as value', 'goods_type_title as text', 'parent_id')
                ->where('parent_id', '>', 0)->get()
        ];

        return $this->api->getMessage($options);
    }
}
