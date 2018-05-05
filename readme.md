# cool1024 web code

## run app
`sudo php -S 0.0.0.0:80 -t public`

## refresh database
1. 更新迁移
`php artisan migrate`
2. 删除所有表 & 迁移
`php artisan migrate:refresh`
3. 创建一个迁移
`php artisan make:migration create_要创建的表名称_table --create=要创建的表名称`

## 填充数据
1. 创建一个填充
`php artisan make:seeder 填充的类名`
2. 全部填充
`php artisan db:seed`
3. 执行指定填充
`php artisan db:seed --class=填充的类名`
## phpunit
1. 测试指定方法
`phpunit --filter AdminTest::testInsertCompany`
