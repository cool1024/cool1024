<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Facade;

class ArticleTest extends TestCase
{
    // use DatabaseTransactions;

    /**
     * 测试添加文章标签接口
     *
     * @return array
     */
    public function testInsertCompany()
    {
        $params = [
            'article_label_name' => $this->faker->name,
        ];
        $this->post('/webblog/article/label/add', $params);
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
        return $response['datas'];
    }

    /**
     * 测试添加文章标签删除接口
     *
     * @return void
     */
    public function testdeleteArticleLabel()
    {
        $article_label = $this->testAddArticleLabel();
        Facade::clearResolvedInstances();
        $response = $this->delete('/webblog/article/label/delete?id=' . $article_label['id']);
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
    }

    /**
     * 测试文章标签列表获取接口
     *
     * @return void
     */
    public function testArticleLabels()
    {
        $this->get('/webblog/article/label/list');
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
    }

    /**
     * 测试添加文章接口
     *
     * @return array
     */
    public function testAddArticle()
    {
        $params = [
            'article_title' => $this->faker->name,
            'article_label_id' => $this->faker->randomDigit,
            'article_content' => $this->faker->realText(),
            'article_thumb' => $this->faker->imageUrl(640, 480),
        ];
        $this->post('/webblog/article/add', $params);
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
        return $response['datas'];
    }

    /**
     * 测试添加文章标签删除接口
     *
     * @return void
     */
    public function testdeleteArticle()
    {
        $article = $this->testAddArticle();
        Facade::clearResolvedInstances();
        $response = $this->delete('/webblog/article/delete?id=' . $article['id']);
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
    }

    /**
     * 测试文章列表获取接口
     *
     * @return void
     */
    public function testArticles()
    {

        $params = [
            'limit' => 10,
            'offset' => 0,
            'article_label_ids' => '1,2,3',
            'created_at' => date('Y-m-d'),
        ];
        $this->get('/webblog/article/list?' . http_build_query($params));
        $this->createHtml(__FUNCTION__);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->log('info', __class__ . '::' . __FUNCTION__, [$response]);
        $this->assertEquals($response['result'], true);
    }
}
