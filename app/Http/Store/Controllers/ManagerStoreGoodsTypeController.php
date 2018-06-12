<?php

/**
 * 商品类型管理控制器
 * 
 * @file   ManagerStoreGoodsTypeController.php
 * @author xiaojian
 * @date   2018-04-27
 */
namespace App\Http\Store\Controllers;

use App\Http\Store\Models\StoreGoodsType;
use App\Api\BaseClass\Controller;
use App\Api\Traits\Func\ArraySortTrait;

class ManagerStoreGoodsTypeController extends Controller
{

    use ArraySortTrait;

    /**
     * 获取所有分类
     */
    public function listGoodsType()
    {
        $datas = with(new StoreGoodsType)->groupData([
            ['op' => 'orderBy', 'params' => ['id', 'asc']]
        ]);

        $parents = [];
        $children = [];
        foreach ($datas as $value) {
            if ($value['parent_id'] === 0) {
                $parents = $value['groups'];
                $parents = $this->array_sort_params($parents, 'id');
            } else {
                $value['groups'] = $this->array_sort_params($value['groups'], 'id');
                $children[] = $value;
            }
        }

        $datas = [
            'parents' => $parents,
            'children' => $children,
        ];

        $datas = json_decode(json_encode($datas, JSON_NUMERIC_CHECK));
        return $this->form->getMessage($datas);
    }

    /**
     * 删除商品分类
     */
    public function deleteGoodsType()
    {
        $rules = [
            ['goods_type_id', 'required|integer']
        ];
        $params = $this->form->camelFormOrFail($rules);

        $goods_type = StoreGoodsType::findOrFail($params['goods_type_id']);
        StoreGoodsType::where('parent_id', $goods_type->id)->delete();
        $result = $goods_type->delete();
        return $this->form->deleteMessage($result);
    }

    /**
     * 保存商品分类
     */
    public function saveGoodsType()
    {
        $rules = [
            ['id', 'required|integer'],
            ['goods_type_title', 'required|max:45'],
            ['children', 'required|array'],
        ];

        $params = $this->form->camelFormOrFail($rules);

        // 判断是否是新的
        if ($params['id'] === 0) {
            $goods_type = StoreGoodsType::create([
                'parent_id' => 0,
                'goods_type_title' => $params['goods_type_title']
            ]);
        } else {
            $goods_type = StoreGoodsType::findOrFail($params['id']);
            $goods_type->fill(['goods_type_title' => $params['goods_type_title']])
                ->save();
        }

        // 校验数据是否正确
        $children = [];
        foreach ($params['children'] as $child) {
            if (!isset($child['id'], $child['goodsTypeTitle'])) {
                return $this->form->error('child datas error');
            }
            $children[] = [
                'id' => $child['id'],
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

        return $this->form->success();
    }
}
