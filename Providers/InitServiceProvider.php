<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: YouHuJun
 * @Date: 2020-02-20 10:47:24
 * @LastEditors: YouHuJun
 * @LastEditTime: 2020-02-22 00:11:03
 */

namespace YouHuJun\LaravelInit\Providers;

use Illuminate\Support\ServiceProvider;

class InitServiceProvider extends ServiceProvider
{
    public function register()
    {
        //绑定mysql门面代理和服务
        $this->app->singleton('Mysql',\YouHuJun\LaravelInit\Service\Facade\Data\MysqlService::class);
    }

    public function boot()
    {
        //启动发布命令
        $this->registerPublish();

        //启动自定义命令
        $this->registerCommand();
    }

    /**
     * @description: 注册发布命令
     * @param {null} 
     * @return: void
     */
    protected function registerPublish()
    {
        //判断是否是在控制台运行
       if ($this->app->runningInConsole()) 
       {
           //单独发布自定义助手函数
           $this->publishes([
               __DIR__.'/../Config/helper.php'=>config_path('helper.php'),

               __DIR__.'/../Config/code.php'=>config_path('code.php')
           ],'help');

           //单独发布门面,契约合服务层
           $this->publishes([
               __DIR__.'/../Publish/Contract'=>app_path('Contract'),
               __DIR__.'/../Publish/Facade/'=>app_path('Facade'),
               __DIR__.'/../Publish/Service'=>app_path('Service'),
               __DIR__.'/../Publish/Service/Facade'=>app_path('Service/Facade'),
               __DIR__.'/../Publish/Service/Contract'=>app_path('Service/Contract'),
           ],'service');

           //单独发布文档
           $this->publishes([
              __DIR__.'/../Documents'=>base_path('Documents'),
           ],'document');

           //单独发布自定义错误视图
           $this->publishes([
               //发布错误视图
                __DIR__.'/../Resources/views/errors/'=>resource_path('views/errors'),
           ],'errorblade');

           $this->publishes([
            //发布配置文件
            __DIR__.'/../Config/helper.php'=>config_path('helper.php'),
            //发布门面,契约和与之对应的服务层
            __DIR__.'/../Publish/Contract'=>app_path('Contract'),
            __DIR__.'/../Publish/Facade/'=>app_path('Facade'),
            __DIR__.'/../Publish/Service'=>app_path('Service'),
            __DIR__.'/../Publish/Service/Facade'=>app_path('Service/Facade'),
            __DIR__.'/../Publish/Service/Contract'=>app_path('Service/Contract'),
            //发布基础使用文档
            __DIR__.'/../Documents'=>base_path('Documents'),

            //发布错误视图
            __DIR__.'/../Resources/views/errors/'=>resource_path('views/errors'),

           ]);
       }
    }

    /**
     * @description: 注册自定义命令
     * @param {type} 
     * @return: 
     */
    protected function registerCommand()
    {
        if($this->app->runningInConsole())
        {
            $this->commands([
                \YouHuJun\LaravelInit\Console\Commands\BuildFacade::class,
                \YouHuJun\LaravelInit\Console\Commands\BuildFacadeService::class,
                \YouHuJun\LaravelInit\Console\Commands\CallFacadeService::class,
            ]);
        }
    }
}
