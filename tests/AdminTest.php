<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Facade;

class AdminTest extends TestCase
{

    /**
     * 测试添加公司
     *
     * @return array
     */
    public function testInsertCompany()
    {
        $params = [
            'company_manager_account' => str_random(8),
            'company_name' => $this->faker->company,
            'is_active' => 0,
            'password' => '123456789',
            'company_manager_mobile' => $this->faker->phoneNumber,
            'company_manager_email' => $this->faker->email,
            'company_description' => $this->faker->paragraph,
            'company_logo' => $this->faker->imageUrl(200, 200),
        ];
        $this->post('admin/company/insert', $params);
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
        return $response['datas'];
    }

    /**
     * 测试获取公司信息
     *
     * @depends testInsertCompany
     */
    public function testGetCompany(array $stack)
    {
        $this->get('admin/company/get?company_id=' . $stack['id']);
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
        return $response['datas'];
    }

    /**
     * 测试更新公司信息
     *
     * @depends testGetCompany
     */
    public function testUpdateCompany(array $stack)
    {

        $params = [
            'id' => $stack['id'],
            'company_manager_account' => str_random(8),
            'company_name' => $this->faker->company,
            'is_active' => 0,
            'password' => 'abcdefgh',
            'company_manager_mobile' => $this->faker->phoneNumber,
            'company_manager_email' => $this->faker->email,
            'company_description' => $this->faker->paragraph,
            'company_logo' => $this->faker->imageUrl(200, 200),
        ];
        $this->put('admin/company/update', $params);
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
    }

    /**
     * 测试删除公司信息
     *
     * @depends testUpdateCompany
     */
    public function testDeleteCompany(array $stack)
    {
        $this->delete('admin/company/delete?company_id=' . $stack['id']);
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
    }

}
