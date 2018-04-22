# cool1024 web code

## run app
`sudo php -S 0.0.0.0:80 -t public`

## refresh database
1. 删除所有表 & 迁移
`php artisan migrate:refresh`

## phpunit
1. 测试指定方法
`phpunit --filter AdminTest::testInsertCompany`
