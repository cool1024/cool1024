<?php

/**
 * 商品类型管理管理控制器
 * 
 * @file   ManagerStoreGoodsTypeController.php
 * @author xiaojian
 * @date   2018-04-27
 */
namespace App\Http\Store\Controllers;

use Illuminate\Support\Facades\Crypt;
use App\Http\Store\Models\StoreGoodsType;

class ManagerStoreGoodsTypeController extends Controller
{

    /**
     * 获取所有分类
     */
    public function listGoodsType()
    {
        $datas = with(new StoreGoodsType)->groupData();

        $parent = [];
        $children = [];
        foreach ($datas as $value) {
            if ($value['parent_id'] === 0) {
                $parents = $value['groups'];
            } else {
                $children[] = $value;
            }
        }

        $datas = [
            'parents' => $parents,
            'children' => $children,
        ];
        $datas = json_decode(json_encode($datas, JSON_NUMERIC_CHECK));

        return $this->api->getMessage($datas);
    }

    /**
     * 删除商品分类
     */
    public function deleteGoodsType()
    {
        $required = ['goods_type_id'];
        $params = $this->api->camelCaseParams($required);

        $goods_type = StoreGoodsType::findOrFail($params['goods_type_id']);
        if ($goods_type->parent_id > 0) {
            StoreGoodsType::where('parent_id', $goods_type->id)->delete();
        }
        $result = $goods_type->delete();
        return $this->api->deleteMessage($result);
    }

    /**
     * 保存商品分类
     */
    public function saveGoodsType()
    {
        $required = ['goods_type_id'];
    }
}
