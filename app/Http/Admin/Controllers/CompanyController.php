<?php

/**
 * 公司管理控制器
 * 
 * @file   CompanyController.php
 * @author xiaojian
 * @date   2018-04-04
 */
namespace App\Http\Admin\Controllers;

use Illuminate\Support\Facades\Crypt;
use App\Http\Admin\Models\AccessCompanyManager;
use App\Api\BaseClass\Controller;
use App\Sdk\OssSdk;

class CompanyController extends Controller
{

    /**
     * 新增公司
     */
    public function insertCompany()
    {

        $rules = [
            ['company_manager_account', 'required|min:4|max:30'],
            ['company_name', 'required|max:100'],
            ['is_active', 'required|boolean'],
            ['password', 'required|min:4|max:20'],
            ['company_manager_mobile', 'min:4|max:30'],
            ['company_manager_email', 'email'],
            ['company_description', 'max:500'],
            ['company_logo', 'max:500'],
        ];

        $params = $this->form->camelFormOrFail($rules);

        $compay = AccessCompanyManager::where('company_manager_account', $params['company_manager_account'])->first();

        if (isset($compay)) {
            return $this->form->error('账号已经被注册');
        }

        $params['password'] = Crypt::encryptString($params['password']);

        return $this->form->createMessage(AccessCompanyManager::create($params));
    }

    /**
     * 获取公司详情
     */
    public function getCompany()
    {

        $rules = [
            ['company_id', 'required|integer']
        ];

        $params = $this->form->camelFormOrFail($rules);

        return $this->form->getMessage(AccessCompanyManager::findOrFail($params['company_id']));
    }

    /**
     * 更新公司详情
     */
    public function updateCompany()
    {
        $rules = [
            ['id', 'required|integer'],
            ['company_manager_account', 'min:4|max:30'],
            ['company_name', 'max:100'],
            ['is_active', 'boolean'],
            ['password', 'min:4|max:20'],
            ['company_manager_mobile', 'min:4|max:30'],
            ['company_manager_email', 'email'],
            ['company_description', 'max:500'],
            ['company_logo', 'max:500'],
        ];

        $params = $this->form->camelFormOrFail($rules);

        if (count($params) <= 1) {
            return $this->form->error('lost update params');
        }

        if (isset($params['password'])) {
            $params['password'] = Crypt::encryptString($params['password']);
        }

        return $this->form->updateMessage(AccessCompanyManager::findOrFail($params['id'])->update($params));
    }

    /**
     * 删除公司
     */
    public function deleteCompany()
    {

        $rules = [
            ['company_id', 'required|integer']
        ];

        $params = $this->form->camelFormOrFail($rules);
        return $this->form->deleteMessage(AccessCompanyManager::findOrFail($params['company_id'])->delete());
    }

    /**
     * 公司列表-分页
     */
    public function searchCompany()
    {
        $rules = [
            ['limit', 'required|integer'],
            ['offset', 'required|integer'],
            ['start', 'date'],
            ['end', 'date'],
            ['name', 'max:100'],
            ['account', 'max:30'],
        ];

        $params = $this->form->camelFormOrFail($rules);

        $search_params = [
            ['whereDate', 'created_at', '>=', '$start'],
            ['whereDate', 'created_at', '<=', '$end'],
            ['where', 'company_name', 'like', '$name'],
            ['where', 'company_manager_account', 'like', '$account'],
        ];

        $search_formats = [
            'name' => '%$name%',
            'account' => '%$account%',
        ];

        $search_result = with(new AccessCompanyManager)->pagination($params, $search_params, $search_formats);
        return $this->form->getMessage($search_result);
    }

    /**
     * 公司图片上传授权
     */
    public function ossUpload()
    {
        // 示例化OssSdk
        $oss = new OssSdk('LTAIJUKgjPNJtHW3', '7R0o8odjGB8eKZm3rrwTC8m9sjYxFh', 'https://hello1024.oss-cn-beijing.aliyuncs.com');
        // 生成文件保存地址
        $file_path = 'upload/company/' . date('Ymdhis') . uniqid(md5(microtime(true)), true);
        // 5000k设置
        return $this->form->getMessage($oss->getAccessDatas(1024 * 5000, 10, $file_path));
    }
}
