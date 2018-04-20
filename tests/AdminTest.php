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
            'companyManagerAccount' => str_random(8),
            'companyName' => $this->faker->company,
            'isActive' => 0,
            'password' => '123456789',
            'companyManagerMobile' => $this->faker->phoneNumber,
            'companyManagerEmail' => $this->faker->email,
            'companyDescription' => $this->faker->paragraph,
            'companyLogo' => $this->faker->imageUrl(200, 200),
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
        $this->get('admin/company/get?companyId=' . $stack['id']);
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
            'companyManagerAccount' => str_random(8),
            'companyName' => $this->faker->company,
            'isActive' => 0,
            'password' => '123456789',
            'companyManagerMobile' => $this->faker->phoneNumber,
            'companyManagerEmail' => $this->faker->email,
            'companyDescription' => $this->faker->paragraph,
            'companyLogo' => $this->faker->imageUrl(200, 200),
        ];
        $this->put('admin/company/update', $params);
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
        return $params;
    }

    /**
     * 测试删除公司信息
     *
     * @depends testUpdateCompany
     */
    public function testDeleteCompany(array $stack)
    {
        $this->delete('admin/company/delete?companyId=' . $stack['id']);
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
    }

    /**
     * 测试公司信息分页查询
     *
     */
    public function testSearchCompany()
    {
        $search_params = [
            'limit' => $this->faker->randomDigit,
            'offset' => $this->faker->randomDigit,
        ];
        $url_params = http_build_query($search_params);
        $this->get('admin/company/search?' . $url_params);
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
    }

}
