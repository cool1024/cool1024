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

## 任务调度
`php /项目目录/artisan schedule:run >> /dev/null 2>&1`
### test on mac
1. 打开控制台，输入 `crontab -e`
2. 按下 i 进入编辑模式
3. 任务书写格式如下

```
* * * * * *

第1个星号表示分钟（0－59）
第2个星号表示小时（0－23）
第3个星号表示日期（0－31）
第4个星号表示月份（0－12）
第5个星号表示星期几（0－6，0是周日，6是周六）
第6个星号表示要执行的脚本文件名。

示例：
*/1 * * * * 1分钟一次
0 13 * * * 表示每天下午13点执行
30 * * * * 表示每30分钟执行
```
4. 如下1分钟执行
`php /Users/anasit/Documents/Git/cool1024/artisan schedule:run >> /dev/null 2>&1`
`php /var/www/cool1024/artisan schedule:run >> /dev/null 2>&1`
5. 保存退出
