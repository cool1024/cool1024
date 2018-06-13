<?php

/**
 * 模型数据分页特性
 * @file:    PageTrait.php
 * @author:  xiaojian
 * @date:    2017-12-16
 */
namespace App\Api\Traits\Orm;

trait PageTrait
{
    /**
     * 分页方法
     * @param array $params 接口参数（必须包含limit和offset）
     * @param array $wheres 查询限制条件 
     * @return array ['total'=>数据总量,'rows'=>[查询结果]]
     */
    public function pagination(array $params, array $wheres = [], array $formats = [])
    {
        // 获取分页必须参数
        $pageLimit = $params['limit'];
        $pageOffset = $params['offset'];
        unset($params['limit'], $params['offset']);

        // 剔除空参数
        foreach ($params as $key => $value) {
            if ((string)$value == '') {
                unset($params[$key]);
            }
        }

        // 格式化参数
        foreach ($formats as $paramKey => $format) {
            if (isset($params[$paramKey])) {
                if (is_callable($format)) {
                    $params[$paramKey] = $format($params[$paramKey]);
                } else if (gettype($format) === 'string') {
                    $params[$paramKey] = str_replace('$' . $paramKey, $params[$paramKey], $format);
                }
            }
        }
        // 过滤无效限制条件
        $activeWheres = [];
        foreach ($wheres as $where) {
            $activeWhere = [
                'function' => array_shift($where),
                'params' => $where,
            ];
            // 解析参数表达式
            foreach ($activeWhere['params'] as $key => $value) {
                switch (gettype($value)) {
                    case 'string':
                        {
                            // 使用变量,那么替换为实际值
                            if (substr($value, 0, 1) === '$') {
                                $paramKey = substr($value, 1);
                                if (isset($params[$paramKey])) {
                                    $activeWhere['params'][$key] = $params[$paramKey];
                                } else {
                                    // 变量参数没有提供那么剔除这个筛选条件
                                    $activeWhere['params'] = [];
                                }
                            }
                            break;
                        }
                    case 'object':
                        {
                            // 使用了转换方法，那么按方法返回值赋予值
                            if (is_callable($value)) {
                                $tempValue = $value($params);
                                if ($tempValue !== null) {
                                    $activeWhere['params'][$key] = $tempValue;
                                } else {
                                    // 方法返回值为空，那么剔除这个筛选条件
                                    $activeWhere['params'] = [];
                                }
                            }
                            break;
                        }
                }
            }
            if (count($activeWhere['params']) <= 0) {
                continue;
            }
            $activeWheres[] = $activeWhere;
        }

        // 执行筛选条件
        $sql = $this;
        foreach ($activeWheres as $activeWhere) {
            $func = $activeWhere['function'];
            $args = $activeWhere['params'];
            $sql = $sql->$func(...$args);
        }

        // 获取统计数据
        $pageDatas = [
            'total' => $sql->count(),
            'rows' => $sql->skip($pageOffset)->take($pageLimit)->get(),
        ];

        return $pageDatas;
    }
}
