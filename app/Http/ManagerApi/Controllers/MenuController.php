<?php

/**
 * 系统菜单控制器
 * 
 * @file   MenuController.php
 * @author xiaojian
 * @date   2018-04-04
 */
namespace App\Http\ManagerApi\Controllers;

use App\Http\ManagerApi\Models\SystemMenuGroup;
use App\Http\ManagerApi\Models\SystemMenu;
use App\Http\ManagerApi\Models\SystemPermission;



class MenuController extends Controller
{
    public function getAllMenu()
    {
        $datas = [
            'groups' => SystemMenuGroup::orderBy('level')->get(),
            'mains' => SystemMenu::where('menu_parent_id', 0)->orderBy('level')->get(),
            'children' => SystemMenu::where('menu_parent_id', '>', 0)->orderBy('level')->get(),
        ];
        return $this->api->getMessage($datas);
    }

    public function insertMenuGroup()
    {
        $params = $this->api->camelCaseParams(['menu_group_name:max:45 ']);
        $group = SystemMenuGroup::where($params)->first();
        if (isset($group)) {
            return $this->api->error('请不要添加重复的分组');
        }
        $max = SystemMenuGroup::max('level');
        $params['level'] = empty($max) ? 1 : ++$max;
        $group = SystemMenuGroup::create($params);
        return $this->api->getMessage($group);
    }

    public function updateMenuGroup()
    {
        $params = $this->api->camelCaseParams([
            'id:integer',
            'menu_group_name:max:45',
        ]);
        $group = SystemMenuGroup::findOrFail($params['id']);
        $group->menu_group_name = $params['menu_group_name'];
        $result = $group->save();
        return $this->api->updateMessage($result);
    }

    public function deleteMenuGroup()
    {
        $params = $this->api->camelCaseParams(['menu_group_id:integer']);
        $result = SystemMenuGroup::findOrFail($params['menu_group_id'])->delete();
        SystemMenu::where($params)->delete();
        return $this->api->deleteMessage($result);
    }

    public function insertMenu()
    {
        $params = $this->api->camelCaseParams(
            [
                'menu_title:max:45',
                'menu_parent_id:integer',
                'menu_group_id:integer',
            ],
            [
                'menu_icon:max:45',
                'menu_url:max:100',
                'permission_id:integer',
            ]
        );
        $max = SystemMenu::where('menu_parent_id', $params['menu_parent_id'])->max('level');
        $params['level'] = empty($max) ? 1 : ++$max;
        $result = SystemMenu::create($params);
        return $this->api->createMessage($result);
    }

    public function updateMenu()
    {
        $params = $this->api->camelCaseParams([
            'id:integer',
            'menu_title:max:45',
            'menu_parent_id:integer',
            'menu_group_id:integer',
        ], [
            'menu_icon:max:45',
            'menu_url:max:100',
            'permission_id:integer',
        ]);
        $result = SystemMenu::findOrFail($params['id'])
            ->fill($params)
            ->save();
        return $this->api->saveMessage($result);
    }

    public function deleteMenu()
    {
        $params = $this->api->camelCaseParams(['menu_id:integer']);
        $result = SystemMenu::findOrFail($params['menu_id'])->delete();
        SystemMenu::where('menu_parent_id', $params['menu_id'])->delete();
        return $this->api->deleteMessage($result);
    }

    public function sortMenu()
    {
        $params = $this->api->camelCaseParams(['ids:array']);
        with(new SystemMenu)->sort($params['ids'], 'level');
        return $this->api->success('排序成功～');
    }

    public function getPermissionOptions()
    {
        return $this->api->getMessage(SystemPermission::all());
    }
}