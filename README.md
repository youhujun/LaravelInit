
<h1 align="center"> youhujun/laravel-init </h1>

<p align="center">一个简单的laravel初始化工具包.(A simple laravel initialization kit.)</p>

---
## 目录(directory)

[1描述(describe)](#1)<span id="0"></span>
<br/>
[2安装(Installing)](#2)
<br/>
[3使用(Usage)](#3)
<br/>
[3.1整体发布(The overall release)](#3.1)
<br/>
[3.1.1执行整体发布命令(Execute the overall issue command)](#3.1.1)
<br/>
[3.2单独发布(Separate release)](#3.2)
<br/>
[3.2.1发布自定义助手文件(Publish custom helper files)](#3.2.1)
<br/>
[3.2.2发布门面,契约和与之对应的服务层(Publish facade, contract and corresponding service layer)](#3.2.2)
<br/>
[3.2.3发布使用文档(Publish usage documentation)](#3.2.3)
<br/>
[3.3命令使用(Command to use)](#3.3)
<br/>
[3.3.1快速创建门面代理和门面服务(Quickly create facade agents and facade services)](#3.3.1)
<br/>
[赞赏(appreciates)](#4)
<br/>
[交流(communication)](#5)
<br/>

---

## <span id="1">1描述(describe)</span>[返回(return)](#0)

这是基于laravel框架开发的,简单的帮助开发者更轻松开发的"小公举"

This is based on the laravel framework, simple "little things" that make it easier for developers to develop


## <span id="2">2安装(Installing)</span>[返回(return)](#0)

```shell
$ composer require youhujun/laravel-init 
```

## <span id="3">3使用(Usage)</span>[返回(return)](#0)

### <span id='3.1'>3.1整体发布(The overall release)</span>[返回(return)](#0)

#### <span id='3.1.1'>3.1.1执行整体发布命令</span>[返回(return)](#0)

>提示:如果你的laravel版本低于5.5,你需要在laravel应用的`config/app.php`中注册ServiceProvider和Facade
>
>Tip: if your laravel is below 5.5, you need to register the ServiceProvider and Facade in `config/app.php` for laravel applications
>
>```
>'providers' => [
>    // ...
>   YouHuJun\LaravelInit\Providers\InitServiceProvider::class,
>]
>```
>
>laravel版本>=5.5的则不用注册,直接看下面文档即可
>
>Laravel version >=5.5 does not need to register, just look at the following documents

---




> ```
> php artisan vendor:publish --provider="YouHuJun\LaravelInit\Providers\InitServiceProvider
> ```
>
> 如果你已经执行了整体发布命令,则下面单独发布命令就不需要继续执行了
>
> If you have executed the overall publish command, the following separate publish command does not need to be executed

---

### <span id='3.2'>3.2单独发布(Separate release)</span>[返回(return)](#0)

>!!说明:如果你选择单独发布,那么3.2.3发布使用文档命令,你必须执行,否则你无法了解如何Mysql门面的使用.
>
>(Note: if you choose to publish separately, then 3.2.3 publish using documentation command, you must execute, otherwise you can't understand how to use Mysql facade).
>
#### <span id='3.2.1'>3.2.1发布自定义助手文件(Publish custom helper files)</span[返回(return)](#0)

>
>```
>php artisan vendor:publish --tag=help
>```
>
>执行完毕后会在 项目根目录/config/目录下添加helper.php文件,里面有定义好的助手函数,你可以在此基础上继续添加你自己需要的自定义助手函数
>
>After the execution, the helper.php file will be added in the project root /config/ directory, which contains defined helper functions. You can then add your own custom helper functions
>
>举例(For example):
>
>```
>if(!function_exists('p'))
> {
>     /**
>      * @description: 打印函数
>      * @param {mixed} 
>      * @return: void
>      */
>     function p($param):void
>     {
>         echo "<pre>";
>         print_r($param);
>         echo "</pre>";
>     }
> }
>```
>
>---
>

#### <span id='3.2.2'>3.2.2发布门面,契约和与之对应的服务层(Publish facade, contract and corresponding service layer)</span>[返回(return)](#0)

>
>```
>php artisan vendor:publish --tag=service
>```
>
>执行完该命令后,会在app目录下,建立Facade,Contract,Service/Facade,Service/Contract目录,用来创建门面和契约服务
>
>Performed after the command, will be in the app directory, set up the Facade, Contract, Service/Facade, Service/Contract, used to create a Facade and Contract services
>
>---
>

#### <span id='3.2.3'>3.2.3发布使用文档(Publish usage documentation)</span[返回(return)](#0)

>
>```
>php artisan vendor:publish --tag=document
>```
>
>当命令执行完毕以后,会在laravel项目根目录下生成如下文档
>
>```
>├──── Documents/ 文档路径  (Document path)
>│
>│──└── Laravel_Readme.md laravel安装配置常用项及注意问题(Laravel installation configuration common items and attention)
>│
>│──└── Facade/ 门面文档路径 (Facade document path)
>│────└── Mysql.md  Mysql门面文档使用介绍(Introduction to Mysql facade documentation)
>```
>
>```
>特别声明:
>后续以laravel框架为基础的继续开发的工具和项目型组件包,无论是开源的,还是私有的都会在安装时发布到Documents目录下.
>Special declaration:
>Subsequent tools and project packages based on the laravel framework, whether open source or proprietary, will be released to the Documents directory at installation time.
>```
>
>查看Mysql文档:[传送门](./Documents/Facade/Mysql.md)
>
>查看Laravel_Readme文档(See the Laravel_Readme documentation):[传送门(portal)](./Documents/Laravel_Readme.md)



---

### <span id='3.3'>3.3命令使用(Command to use)</span>[返回(return)](#0)

>!!!前提:在你执行了3.1或者3.2.2的操作的前提下才可以使用该命令!!!
>
>!!!Premise: you can use this command only if you have performed 3.1 or 3.2.2 operations!!!
>

#### <span id='3.3.1'>3.3.1快速创建门面代理和门面服务(Quickly create facade agents and facade services)</span>[返回(return)](#0)

>
>```
>php artisan call:facade [门面名称(name)|命名空间(namespace)\门面名称(name)]
>```
>
>例如(for example):
>
>```
>php artisan call:facade Data\Memcache
>```
>
>当你执行完该命令以后,如果控制台显示(After you have executed the command, if the console displays)
>
>```
>Facade created successfully.
>FacadeService created successfully.
>```
>
>说明你的命令执行成功!(Your command was executed successfully!)
>
>该命令将会创建 `app\Facade\Data\Memcache.php`和`app\Service\Facade\Data\Memcache.php`文件
>
>接下你只需要进行剩下的步骤,就可以测试默认生成服务的test()方法了!
>
>现在开始尝试一下吧!
>
>This command will create` app\Facade\Data\ memcache.php`and `app\Service\Facade\Data\ memcache.php ` files
>
>Now you just need to go through the rest of the steps to test the test() method that generates the service by default!
>
>Try it now!
>
>

## <span id='4'></span>赞赏(appreciates)[返回(return)](#0)
如果主人觉得该组件有点"小公举",还请主人不吝赏赐!

If the host feel that the component is a little "small public ", also ask the host not stingy reward!

![微信赞赏](./images/wx_like.png)

---

## <span id='5'>交流(communication)</span>[返回(return)](#0)

如果想改进该组件,或者有好的有化建议,欢迎批评指正,一起交流!

If you want to improve the component, or have good Suggestions, welcome the criticism and correction, together with the exchange!

可以加QQ交流群 Can add QQ communication group


QQ群:557510608


扫描下方二维码,可加微信好友:

Scan the qr code below, you can add WeChat friends:

![游鹄君微信二维码](./images/weixin.jpg)





## 贡献(Contributing)[返回(return)](#0)

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com//youhujun/laravel-init/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com//youhujun/laravel-init/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## 许可(License)[返回(return)](#0)

MIT