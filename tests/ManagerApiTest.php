<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Facade;
use App\Http\ManagerApi\Models\SystemToken;

class ManagerApiTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * 测试管理员登入
     */
    public function testLogin()
    {
        $params = [
            'account' => 'admin',
            'password' => '123456789'
        ];
        $this->post('managerapi/signin', $params);
        $this->createHtml(__class__, __FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$params, $response]);
        $this->assertEquals($response['result'], true);
        return $response['datas'];
    }

    /**
     * 测试管理信息获取
     */
    public function testInfo()
    {
        $params = $this->getManagerTokenParams();
        $this->post('managerapi/check', $params);
        $this->createHtml(__class__, __FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$params, $response]);
        $this->assertEquals($response['result'], true);
        return $response['datas'];
    }

    /**
     * 测试系统菜单加载
     */
    public function testMenuLoad()
    {
        $tokenParams = $this->getManagerTokenParams();
        $this->get('managerapi/menu', $tokenParams);
        $this->createHtml(__class__, __FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
        return $response['datas'];
    }

    /**
     * 测试添加平台管理员
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
        $this->createHtml(__class__, __FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
        return $response['datas'];
    }


    /**
     * 获取一个管理员的令牌参数
     */
    private function getManagerTokenParams()
    {
        $token = SystemToken::first();
        return [
            'ng-params-one' => $token->id,
            'ng-params-two' => $token->token,
            'ng-params-three' => $token->platform
        ];
    }
}