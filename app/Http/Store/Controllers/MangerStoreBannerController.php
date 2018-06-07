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

class MangerStoreBannerController extends Controller
{

    /**
     * 获取所有幻灯片
     */
    public function getAllBanner()
    {
        $banners = StoreBanner::orderBy('level')
            ->get(['id', 'banner_src', 'banner_link']);
        return $this->api->getMessage($banners);
    }

    /**
     * 更新幻灯片
     */
    public function updateBanner()
    {
        $required = [
            'id:integer',
            'banner_src:max:200',
        ];

        $expected = [
            'banner_link:max:200'
        ];

        $params = $this->api->camelCaseParams($required, $expected);
        $banner = StoreBanner::findOrFail($params['id'])
            ->fill($params)
            ->save();
        return $this->api->saveMessage($banner);
    }

    /**
     * 更新幻灯片
     */
    public function insertBanner()
    {
        $required = [
            'banner_src:max:200',
        ];

        $expected = [
            'banner_link:max:200'
        ];

        $params = $this->api->camelCaseParams($required, $expected);
        $max = StoreBanner::max('level');
        $params['level'] = empty($max) ? 1 : ++$max;
        $banner = StoreBanner::create($params);
        return $this->api->createMessage($banner);
    }

    /**
     * 删除幻灯片
     */
    public function deleteBanner()
    {
        $required = [
            'banner_id:integer',
        ];
        $params = $this->api->camelCaseParams($required);
        $result = StoreBanner::findOrFail($params['banner_id'])->delete();
        return $this->api->deleteMessage($result);
    }

    /**
     * 幻灯片排序
     */
    public function sortBanner()
    {
        $required = [
            'ids:array',
        ];
        $params = $this->api->camelCaseParams($required);
        with(new StoreBanner)->sort($params['ids'], 'level');
        return $this->api->success('排序成功');
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
        return $this->api->getMessage($oss->getAccessDatas(1024 * 5000, 10, $file_path));
    }
}
