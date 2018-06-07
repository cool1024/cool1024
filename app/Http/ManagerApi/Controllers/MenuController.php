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
use App\Core\Facades\User;
use App\Api\BaseClass\Controller;

class MenuController extends Controller
{
    public function getAllMenu()
    {
        $datas = [
            'groups' => SystemMenuGroup::orderBy('level')->get(),
            'mains' => SystemMenu::where('menu_parent_id', 0)->orderBy('level')->get(),
            'children' => SystemMenu::where('menu_parent_id', '>', 0)->orderBy('level')->get(),
        ];
        return $this->form->getMessage($datas);
    }

    public function insertMenuGroup()
    {
        $params = $this->form->camelFormOrFail([
            ['menu_group_name', 'required|max:45']
        ]);
        $group = SystemMenuGroup::where($params)->first();
        if (isset($group)) {
            return $this->form->error('请不要添加重复的分组');
        }
        $max = SystemMenuGroup::max('level');
        $params['level'] = empty($max) ? 1 : ++$max;
        $group = SystemMenuGroup::create($params);
        return $this->form->getMessage($group);
    }

    public function updateMenuGroup()
    {
        $params = $this->form->camelFormOrFail([
            ['id', 'required|integer'],
            ['menu_group_name', 'required|max:45'],
        ]);
        $group = SystemMenuGroup::findOrFail($params['id']);
        $group->menu_group_name = $params['menu_group_name'];
        $result = $group->save();
        return $this->form->updateMessage($result);
    }

    public function deleteMenuGroup()
    {
        $params = $this->form->camelFormOrFail([
            ['menu_group_id', 'required|integer']
        ]);
        $result = SystemMenuGroup::findOrFail($params['menu_group_id'])->delete();
        SystemMenu::where($params)->delete();
        return $this->form->deleteMessage($result);
    }

    public function sortMenuGroup()
    {
        $params = $this->form->camelFormOrFail([
            ['ids', 'required|array']
        ]);
        with(new SystemMenuGroup)->sort($params['ids'], 'level');
        return $this->form->success('排序成功～');
    }

    public function insertMenu()
    {
        $params = $this->form->camelFormOrFail(
            [
                ['menu_title', 'required|max:45'],
                ['menu_parent_id', 'required|integer'],
                ['menu_group_id', 'required|integer'],
                ['menu_icon', 'max:45'],
                ['menu_url', 'max:100'],
                ['menu_image', 'string'],
                ['permission_id', 'integer'],
            ]
        );
        $max = SystemMenu::where('menu_parent_id', $params['menu_parent_id'])->max('level');
        $params['level'] = empty($max) ? 1 : ++$max;
        $result = SystemMenu::create($params);
        return $this->form->createMessage($result);
    }

    public function updateMenu()
    {
        $params = $this->form->camelFormOrFail([
            ['id', 'required|integer'],
            ['menu_title', 'required|max:45'],
            ['menu_parent_id', 'required|integer'],
            ['menu_group_id', 'required|integer'],
            ['menu_icon', 'max:45'],
            ['menu_url', 'max:100'],
            ['menu_image', 'string'],
            ['permission_id', 'integer'],
        ]);
        $result = SystemMenu::findOrFail($params['id'])
            ->fill($params)
            ->save();
        return $this->form->saveMessage($result);
    }

    public function deleteMenu()
    {
        $params = $this->form->camelFormOrFail([
            ['menu_id', 'required|integer']
        ]);
        $result = SystemMenu::findOrFail($params['menu_id'])->delete();
        SystemMenu::where('menu_parent_id', $params['menu_id'])->delete();
        return $this->form->deleteMessage($result);
    }

    public function sortMenu()
    {

        $params = $this->form->camelFormOrFail([
            ['ids', 'required|array']
        ]);
        with(new SystemMenu)->sort($params['ids'], 'level');
        return $this->form->success('排序成功～');
    }

    public function getPermissionOptions()
    {
        return $this->form->getMessage(SystemPermission::all());
    }

    /**
     * 获取我的菜单
     */
    public function getAuthMenu()
    {
        $permission_ids = User::permissions();
        $permission_ids[] = 0;
        $models = [];
        $groups = SystemMenuGroup::orderBy('level')->get();
        foreach ($groups as $group) {
            $model = [
                'title' => $group->menu_group_name,
                'menus' => [],
            ];
            $mainMenus = SystemMenu::where([
                ['menu_group_id', '=', $group->id],
                ['menu_parent_id', '=', 0],
            ])->orderBy('level')->get();
            foreach ($mainMenus as $main) {
                $mainMenu = [
                    'icon' => $main->menu_icon,
                    'title' => $main->menu_title,
                    'image' => $main->menu_image,
                    'children' => []
                ];
                $childMenus = SystemMenu::where('menu_parent_id', '=', $main->id)
                    ->whereIn('permission_id', $permission_ids)
                    ->orderBy('level')
                    ->get();
                foreach ($childMenus as $child) {
                    $childMenu = [
                        'title' => $child->menu_title,
                        'url' => $child->menu_url,
                    ];
                    $mainMenu['children'][] = $childMenu;
                }
                if (count($mainMenu['children']) > 0) {
                    $model['menus'][] = $mainMenu;
                }
            }
            if (count($model['menus']) > 0) {
                $models[] = $model;
            }
        }

        return $this->form->getMessage($models);
    }
}
