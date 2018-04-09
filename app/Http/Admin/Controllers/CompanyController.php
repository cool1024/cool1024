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

class CompanyController extends Controller
{

    /**
     * 新增公司
     */
    public function insertCompany()
    {

        $required = [
            'company_manager_account:min:4|max:30',
            'company_name:max:100',
            'is_active:boolean',
            'password:min:4|max:20',
        ];

        $expected = [
            'company_manager_mobile:min:4|max:30',
            'company_manager_email:email',
            'company_description:max:500',
            'company_logo:max:100',
        ];

        $params = $this->api->checkParams($required, $expected);

        $params['password'] = Crypt::encryptString($params['password']);

        return $this->api->createMessage(AccessCompanyManager::create($params));
    }

    /**
     * 获取公司详情
     */
    public function getCompany()
    {

        $required = [
            'company_id:integer'
        ];

        $params = $this->api->checkParams($required);

        return $this->api->getMessage(AccessCompanyManager::findOrFail($params['company_id']));
    }

    /**
     * 更新公司详情
     */
    public function updateCompany()
    {

        $required = [
            'id:integer'
        ];

        $expected = [
            'company_manager_account:min:4|max:30',
            'company_name:max:100',
            'is_active:boolean',
            'password:min:4|max:20',
            'company_manager_mobile:min:4|max:30',
            'company_manager_email:email',
            'company_description:max:500',
            'company_logo:max:100',
        ];

        $params = $this->api->checkParams($required, $expected);

        if (count($params) <= 1) {
            return $this->api->error('lost update params');
        }

        if (isset($params['password'])) {
            $params['password'] = Crypt::encryptString($params['password']);
        }

        return $this->api->updateMessage(AccessCompanyManager::findOrFail($params['id'])->update($params));
    }

    /**
     * 删除公司
     */
    public function deleteCompany()
    {

        $required = [
            'company_id:integer'
        ];

        $params = $this->api->checkParams($required);
        return $this->api->deleteMessage(AccessCompanyManager::findOrFail($params['company_id'])->delete());
    }

    /**
     * 公司列表-分页
     */
    public function searchCompany()
    {
        $required = [
            'limit:integer',
            'offset:integer',
        ];

        $params = $this->api->checkParams($required);
        $search_result = with(new AccessCompanyManager)->search($params);
        return $this->api->searchMessage($search_result);
    }
}
