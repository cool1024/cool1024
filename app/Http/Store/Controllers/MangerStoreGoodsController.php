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
use App\Sdk\OssSdk;

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
            $datas['goodsSpecificationDetails'][] = [
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
     * 保存商品规格
     */
    public function saveGoodsSpecification()
    {
        $required = [
            'goods_id:integer',
            'goods_specifications:array',
            'goods_specification_details:array',
        ];
        $params = $this->api->camelCaseParams($required);

        $goods = StoreGoods::findOrFail($params['goods_id']);

        $specifications = [];
        foreach ($params['goods_specifications'] as $specification) {
            if (!isset($specification['specificationTitle'], $specification['specificationNames'])
                || gettype($specification['specificationNames']) !== 'array') {
                return $this->api->error('goods_specifications data error');
            }
            $specifications[] = [
                'goods_id' => $goods->id,
                'specification_title' => $specification['specificationTitle'],
                'specification_names' => serialize($specification['specificationNames'])
            ];
        }

        $specification_details = [];
        foreach ($params['goods_specification_details'] as $detail) {
            if (!isset($detail['specificationTitleIndexs'], $detail['specificationTitles'])
                || gettype($detail['specificationTitleIndexs']) !== 'array'
                || gettype($detail['specificationTitles']) !== 'array') {
                return $this->api->error('goods_specification_details data error');
            }
            $specification_details[] = [
                'goods_id' => $goods->id,
                'specification_titles' => serialize($detail['specificationTitles']),
                'specification_title_indexs' => serialize($detail['specificationTitleIndexs']),
                'goods_price' => isset($detail['goodsPrice']) ? $detail['goodsPrice'] : 0,
                'goods_stocks' => isset($detail['goodsStocks']) ? $detail['goodsStocks'] : 0,
                'is_active' => isset($detail['isActive']) ? $detail['isActive'] : 0
            ];
        }
        // 清空旧的规格
        StoreGoodsSpecification::where('goods_id', $goods->id)->delete();
        StoreGoodsSpecificationDetail::where('goods_id', $goods->id)->delete();

        // 插入新的规格
        foreach ($specifications as $specification) {
            StoreGoodsSpecification::create($specification);
        }
        foreach ($specification_details as $detail) {
            StoreGoodsSpecificationDetail::create($detail);
        }

        return $this->api->getMessage('save success');
    }

    /**
     * 添加商品详情
     */
    public function insertGoods()
    {
        $required = [
            'goods_detail:max:2000',
            'goods_thumb:max:200',
            'goods_images:max:1000',
            'goods_name:max:100',
            'goods_stocks:integer',
            'goods_price',
            'is_active:boolean',
            'goods_type:integer',
        ];

        $params = $this->api->camelCaseParams($required);

        $goods = StoreGoods::create($params);

        return $this->api->getMessage($goods);
    }

    /**
     * 修改商品详情
     */
    public function updateGoods()
    {
        $required = [
            'id:integer',
        ];

        $expected = [
            'goods_detail:max:2000',
            'goods_thumb:max:200',
            'goods_images:max:1000',
            'goods_name:max:100',
            'goods_stocks:integer',
            'goods_price',
            'is_active:boolean',
            'goods_type:integer',
        ];

        $params = $this->api->camelCaseParams($required, $expected);
        if (count($params) < 2) {
            return $this->api->error('缺少更新的参数');
        }

        StoreGoods::findOrFail($params['id'])
            ->fill($params)
            ->save();

        return $this->api->getMessage('save success');
    }

    /**
     * 删除商品
     */
    public function deleteGoods()
    {
        $required = ['goods_id:integer', ];
        $params = $this->api->camelCaseParams($required);
        $result = StoreGoods::findOrFail($params['goods_id'])->delete();
        StoreGoodsSpecification::where($params)->delete();
        StoreGoodsSpecificationDetail::where($params)->delete();
        return $this->api->deleteMessage($result);
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

    /**
     * 商品图片上传授权
     */
    public function ossUpload()
    {
        // 示例化OssSdk
        $oss = new OssSdk('LTAIJUKgjPNJtHW3', '7R0o8odjGB8eKZm3rrwTC8m9sjYxFh', 'https://hello1024.oss-cn-beijing.aliyuncs.com');
        // 生成文件保存地址
        $file_path = 'upload/goods/' . date('Ymdhis') . uniqid();
        // 5000k设置
        return $this->api->getMessage($oss->getAccessDatas(1024 * 5000, 10, $file_path));
    }
}
