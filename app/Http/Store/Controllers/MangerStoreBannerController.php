<?php

/**
 * 幻灯片管理控制器
 * 
 * @file   MangerStoreBannerController.php
 * @author xiaojian
 * @date   2018-04-27
 */
namespace App\Http\Store\Controllers;

use App\Http\Store\Models\StoreBanner;
use App\Sdk\OssSdk;
use App\Api\BaseClass\Controller;

class MangerStoreBannerController extends Controller
{

    /**
     * 获取所有幻灯片
     */
    public function getAllBanner()
    {
        $banners = StoreBanner::orderBy('level')
            ->get(['id', 'banner_src', 'banner_link']);
        return $this->form->getMessage($banners);
    }

    /**
     * 更新幻灯片
     */
    public function updateBanner()
    {
        $rules = [
            ['id', 'required|integer'],
            ['banner_src', 'required|max:200'],
            ['banner_link', 'nullable|max:200']
        ];
        $params = $this->form->camelFormOrFail($rules);
        $banner = StoreBanner::findOrFail($params['id'])
            ->fill($params)
            ->save();
        return $this->form->saveMessage($banner);
    }

    /**
     * 新增幻灯片
     */
    public function insertBanner()
    {
        $rules = [
            ['banner_src', 'required|max:200'],
            ['banner_link', 'max:200']
        ];

        $params = $this->form->camelFormOrFail($rules);
        $max = StoreBanner::max('level');
        $params['level'] = empty($max) ? 1 : ++$max;
        $banner = StoreBanner::create($params);
        return $this->form->createMessage($banner);
    }

    /**
     * 删除幻灯片
     */
    public function deleteBanner()
    {
        $rules = [
            ['banner_id', 'required|integer'],
        ];
        $params = $this->form->camelFormOrFail($rules);
        $result = StoreBanner::findOrFail($params['banner_id'])->delete();
        return $this->form->deleteMessage($result);
    }

    /**
     * 幻灯片排序
     */
    public function sortBanner()
    {
        $rules = [
            ['ids', 'required|array'],
        ];
        $params = $this->form->camelFormOrFail($rules);
        with(new StoreBanner)->sort($params['ids'], 'level');
        return $this->form->success('排序成功');
    }

    /**
     * 图片上传授权
     */
    public function ossUpload()
    {
        // 实例化OssSdk
        $oss = new OssSdk('LTAIJUKgjPNJtHW3', '7R0o8odjGB8eKZm3rrwTC8m9sjYxFh', 'https://hello1024.oss-cn-beijing.aliyuncs.com');
        // 生成文件保存地址
        $file_path = 'upload/banner/' . date('Ymdhis') . uniqid();
        // 5000k设置
        return $this->form->getMessage($oss->getAccessDatas(1024 * 5000, 10, $file_path));
    }
}
