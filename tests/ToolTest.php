<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ToolTest extends TestCase
{
    /**
     * 测试文件上传
     *
     * @return array
     */
    public function testUpload()
    {
        $this->call('POST', 'webblog/tools-ui/upload', [], [], ['file' => UploadedFile::fake()->image(md5(time()) . '.jpg')]);
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $apiData = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, $apiData);
        $this->assertEquals($apiData['result'], true);
        return $apiData['datas'];
    }
}
