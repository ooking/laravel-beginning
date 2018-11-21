- 基于 Laravel + Dingo api + JWT + laravel-admin 的基础项目
- 基于 rest api 完成了注册登录等接口，修改后直接使用
- 前后台和接口独立域名

启动新项目直接使用节省时间

版本：
- Laravel 5.7.13
- Dingo api 2.0.0-alpha2
- JWT rc.3
- laravel-admin 1.6.7

以下所有例子都是使用 lvbegin.com 域名

接口地址: http://api.lvbegin.com
管理端:http://admin.lvbegin.com
门户:http://www.lvbegin.com

##### 开发环境部署
```
$ git clone git@github.com:ooking/laravel-beginning.git
$ composer install
$ cp .env.example .env
```
根据实际情况修改设置,特别是数据库和REDIS,还有下面两个
```
ADMIN_DOMAIN=admin.lvbegin.com
API_DOMAIN=api.lvbegin.com
```
继续执行下面命令
```
$ php artisan key:generate
$ php artisan admin:install
# 上面命令会有错误： 『Admin directory already exists !』 请忽略！
$ php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
$ php artisan jwt:secret
$ php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
$ php artisan vendor:publish --provider="Dingo\Api\Provider\LaravelServiceProvider"
```
以上执行完毕，并且修改了虚拟主机配置后可以通过浏览器打开

http://admin.lvbegin.com 测试管理端，账号和密码： admin

http://api.lvbegin.com 接口需要通过 postman 测试

##### 接口列表：

![接口列表](https://upload-images.jianshu.io/upload_images/4315462-88722c7251fd8234.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

测试的时候记得先调用注册接口注册一个用户先

##### 虚拟主机参考
```
server {
    listen 80;
    server_name api.lvbegin.com admin.lvbegin.com www.lvbegin.com;
    index index.php index.html index.htm;
    root /data/www/laravel-beginning/public; # default Laravel's entry point for all requests
    set_real_ip_from 10.104.17.235;
    real_ip_header X-Forwarded-For;
    real_ip_recursive on;
    location / {
        # try to serve file directly, fallback to index.php
        try_files $uri /index.php?$args;
    }
    location ~ \.php$ {
        fastcgi_index index.php;
        fastcgi_pass 127.0.0.1:9000; # address of a fastCGI server
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
        include fastcgi_params;
    }
}
```
##### 截图
![管理端](https://upload-images.jianshu.io/upload_images/4315462-080a593681d57027.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![管理端](https://upload-images.jianshu.io/upload_images/4315462-98979bcbba035111.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![POSTMAN 调试](https://upload-images.jianshu.io/upload_images/4315462-6796bba7f7490108.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

##### 参考
- laravel 安装
[https://laravel.com/docs/5.7/installation](https://laravel.com/docs/5.7/installation)
- laravel-admin 安装
https://laravel-admin.org/docs/zh/installation
- dingo api 安装
https://github.com/dingo/api/wiki/Installation
- JWT 安装
[https://jwt-auth.readthedocs.io/en/develop/laravel-installation/](https://jwt-auth.readthedocs.io/en/develop/laravel-installation/)
