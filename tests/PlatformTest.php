<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Facade;

class PlatformTest extends TestCase
{

    /**
     * 测试添加平台管理员
     *
     * @return array
     */
    public function testInsertPlatfromManager()
    {
        $params = [
            'platformManagerAccount' => str_random(8),
            'platformManagerName' => $this->faker->company,
            'isActive' => 0,
            'password' => '123456789',
            'platformManagerMobile' => $this->faker->phoneNumber,
            'platformManagerEmail' => $this->faker->email,
        ];
        $this->post('admin/platform/insert', $params);
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
        return $response['datas'];
    }
}
