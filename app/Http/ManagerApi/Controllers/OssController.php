<?php

/**
 * OSS控制器
 * 
 * @file   OssController.php
 * @author xiaojian
 * @date   2018-04-04
 */
namespace App\Http\ManagerApi\Controllers;

use App\Api\BaseClass\Controller;
use App\Sdk\OssSdk;

class OssController extends Controller
{

    private $oss;

    public function __construct()
    {
        parent::__construct();
        $this->oss = new OssSdk('LTAIJUKgjPNJtHW3', '7R0o8odjGB8eKZm3rrwTC8m9sjYxFh', 'https://hello1024.oss-cn-beijing.aliyuncs.com');
    }

    /**
     * quill编辑器测试文件保存
     */
    public function quillExampleUpload()
    {
        // 固定了保存内容为upload/temp.txt(注意文件后缀为前端给予)
        $file_path = 'upload/temp';
        // 5000k设置--文档不能超过5000K
        return $this->form->getMessage($this->oss->getAccessDatas(1024 * 5000, 10, $file_path));
    }

}
