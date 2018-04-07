<?php

/**
 * 公司管理控制器
 * 
 * @file   CompanyController.php
 * @author xiaojian
 * @date   2018-04-04
 */
namespace App\Http\Admin\Controllers;

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
            'company_manager_email:boolean',
            'company_description:max:500',
            'company_logo:max:100',
        ];

        $params = $this->api->checkParams($required, $expected);

        $params['password']
      
        return $this->api->create_message((new ArticleLabel)->create($params));
    }

    /**
     * 添加文章标签
     */
    public function addArticleLabel()
    {
        $params = $this->api->checkParams(['article_label_name']);
        $max_label_level = with(new ArticleLabel)->max('article_label_level');
        $params['article_label_level'] = empty($max_label_level) ? 1 : ++$max_label_level;
        return $this->api->create_message((new ArticleLabel)->create($params));
    }

    /**
     * 删除文章标签
     */
    public function deleteArticleLabel()
    {
        $params = $this->api->checkParams(['id']);
        $article_label = (new ArticleLabel)->findOrFail($params['id']);
        return $this->api->delete_message($article_label->delete());
    }

    /**
     * 获取文章列表，分页，查询
     */
    public function articles()
    {
        $params = $this->api->checkParams(['offset:integer', 'limit:integer'], ['article_label_ids', 'created_at']);
        $search_params = [
            ['whereIn', 'article_label_id', '$article_label_ids'],
            ['whereDate', 'created_at', '<=', '$created_at']
        ];
        $format_ops = [
            'article_label_ids' => function ($param) {
                return explode(',', $param);
            }
        ];
        $paginations = with(new Article)->search($params);
        return $this->api->paginate($paginations);
    }

    /**
     * 添加文章
     */
    public function addArticle()
    {
        $params = $this->api->checkParams(['article_title', 'article_label_id', 'article_content', 'article_thumb']);
        return $this->api->create_message((new Article)->create($params));
    }

    /**
     * 删除文章
     */
    public function deleteArticle()
    {
        $params = $this->api->checkParams(['id']);
        $article = (new Article)->findOrFail($params['id']);
        return $this->api->delete_message($article->delete());
    }
}
