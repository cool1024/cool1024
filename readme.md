# cool1024 web code

## composer config
`composer config -g repo.packagist composer https://packagist.phpcomposer.com`
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

## 任务队列
1. 运行队列监听
`php artisan queue:work`
2. 清空所有队列
`php artisan queue:flush`
3. 任务代码修改好要重启队列才能生效
`php artisan queue:restart`
4. 安装队列驱动服务
`OS X:   brew install beanstalkd`
`Debian: apt-get install`
5. 运行队列服务
`beanstalkd -l localhost -p 11300`
6. 其它指令介绍
```
php artisan queue:listen connection_name --queue=queue_name
 
php artisan queue:listen connection //指定连接,也就是不同队列类型,如database,redis,在queue.php中配置
 
php artisan queue:listen --queue=high,low //指定队列优先级,比如有限处理某队列,多个队列用,分割
 
php artisan queue:listen --timeout=60 //每个任务运行最大时间不超过60秒
 
php artisan queue:listen --sleep=5 //没有任务的时候休眠5秒
 
php artisan queue:listen --tries=3 //失败任务尝试3次
```
7. env文件配置
`QUEUE_DRIVER=beanstalkd`

## 事件
1. 事件需要注册，一个事件可以绑定多个监听器
`App\Core\Providers\EventServiceProvider`
2. 事件对象就是一个单纯保存这个事件相关消息的东东
3. 监听器会在事件触发的时候执行相关的handle方法
4. 事件时要主动触发的，使用`event(new ExampleEvent)`方法可以发送一个事件
5. EventServiceProvider服务提供商和其他的不一样，它继承了事件服务提供商（Laravel\Lumen\Providers\EventServiceProvider）

## ORM观察者

1. orm事件可以在任何服务提商中的boot方法内注册
2. 不一定非要在服务提供商中注册，只是这个位置比较好
3. 观察者这个类就是一个简单的类，没有继承其他的任何父类
