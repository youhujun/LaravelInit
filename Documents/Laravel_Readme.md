# 基于laravel6.0的业务原型文档

[一安装配置](#1)   <span id="0">顶部</span>
<br>
[1.1安装依赖](#1.1)
<br>
[1.2配置文件](#1.2)
<br>
[1.2.1检查有没有.env文件,没有生成.env文件](#1.2.1)
<br>
[1.2.2其他跟配置有关注意](#1.2.2)
<br>
[二文档说明](#2)
<br>
[三联系方式](#3)
<br>

查看框架版本


`php artisan -V`

---
## <span id="1.1">一安装配置</span>[返回](#0)
### <span id="1.1">1.1安装依赖</span>[返回](#0)

```
composer install
```

---

### <span id="1.2">1.2配置文件[返回](#0)

#### <span id="1.2.1"></span>1.2.1检查有没有.env文件,没有生成.env文件[返回](#0)

1 将`.env.example`文件复制,重命名`.env`,windows下无法创建也可以 `touch .env`然后复制`.env.example`内容

2 执行 `php artisan key:generate`生成应用秘钥

3注意配置

3.1 root 路径指向 public 目录下

3.2 nginx 支持 URL 美化 (本人使用nginx)

```
location /
{
 try_files uri uri/ /index.php?$query_string;
}

```

4 apache

框架中自带的 public/.htaccess 文件支持隐藏 URL 中的 index.php，如过你的 Laravel 应用使用 Apache 作为服务器，需要先确保 Apache 启用了 mod_rewrite 模块以支持 .htaccess 解析。

如果 Laravel 自带的 `.htaccess` 文件不起作用，试试将其中内容做如下替换：

```
Options +FollowSymLinks -Indexes

RewriteEngine On

RewriteCond %{HTTP:Authorization} .

RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

RewriteCond %{REQUEST_FILENAME} !-d

RewriteCond %{REQUEST_FILENAME} !-f

RewriteRule ^ index.php [L]

```

---

### <span id="1.2.2"></span>1.2.2其他跟配置有关注意[返回](#0)

1获取环境变量配置值


示例:传递到 env() 函数的第二个参数是默认值，如果环境变量没有被配置将会使用该默认值。

```
env('APP_DEBUG', false);
```

2访问配置值

示例:app 是配置文件名，timezone 是配置项，配置项有多个层级（数组）的话，使用 . 进行分隔

```
config('app.timezone'); 
```

3如果要在运行时设置配置值，传递数组参数到 config方法即可：

```
config(['app.timezone' => 'Asia/Shanghai']);
```

4基础维护模式

关闭:

`php artisan down`

开启:

`php artisan up`

---

 ## <span id="2">二文档说明</span>[返回](#0)

```
相关文档详情,请查看相关文档--示例(for example):

├──── documents 文档路径  
│
│──└── documents/Facade 门面文档路径
│
│────└── documents/Facade/Mysql.md  门面文档下的Mysql门面文档

```

---

##<span id="3">三联系方式</span>[返回](#0)

如有修改建议,可以联系作者

```
作者(author):游鹄君

微信(同电话):156-8852-3140

qq:2900976495

```

