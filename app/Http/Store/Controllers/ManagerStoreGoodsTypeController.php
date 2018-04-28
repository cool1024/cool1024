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
        $required = ['goods_type_id:integer'];
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
        $required = [
            'id:integer',
            'goods_type_title:max:45',
            'children:array',
        ];

        $params = $this->api->camelCaseParams($required);

        // 判断是否是新的
        if ($params['id'] === 0) {
            $goods_type = StoreGoodsType::create([
                'parent_id' => 0,
                'goods_type_title' => $params['goods_type_title']
            ]);
        } else {
            $goods_type = StoreGoodsType::findOrFail();
            $goods_type->fill(['goods_type_title' => $params['goods_type_title']])
                ->save();
        }

        // 校验数据是否正确
        $children = [];
        foreach ($params['children'] as $child) {
            if (!isset($child['id'], $child['goodsTypeTitle'])) {
                return $this->api->error('child datas error');
            }
            $children[] = [
                'id' => $params['id'],
                'goods_type_title' => $child['goodsTypeTitle'],
            ];
        }

        // 更新或插入
        foreach ($children as $type) {
            $child = $type['id'] === 0 ? new StoreGoodsType : StoreGoodsType::findOrFail($type['id']);
            $child->fill([
                'parent_id' => $goods_type->id,
                'goods_type_title' => $type['goods_type_title'],
            ])->save();
        }

        return $this->api->success();
    }
}
