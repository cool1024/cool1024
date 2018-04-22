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
            'company_logo:max:500',
        ];

        $params = $this->api->camelCaseParams($required, $expected);

        $compay = AccessCompanyManager::where('company_manager_account', $params['company_manager_account'])->first();

        if (isset($compay)) {
            return $this->api->error('账号已经被注册');
        }

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

        $params = $this->api->camelCaseParams($required);

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
            'company_logo:max:500',
        ];

        $params = $this->api->camelCaseParams($required, $expected);

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

        $params = $this->api->camelCaseParams($required);
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

        $expected = [
            'start:date',
            'end:date',
            'name:max:100',
            'account:max:30',
        ];

        $params = $this->api->camelCaseParams($required, $expected);

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

        $search_result = with(new AccessCompanyManager)->search($params, $search_params, $search_formats);
        return $this->api->searchMessage($search_result);
    }
}
