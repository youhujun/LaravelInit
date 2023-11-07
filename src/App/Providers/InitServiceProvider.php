<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: YouHuJun
 * @Date: 2020-02-20 10:47:24
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-11-07 11:26:09
 */

namespace YouHuJun\LaravelInit\App\Providers;

use Illuminate\Support\ServiceProvider;

class InitServiceProvider extends ServiceProvider
{
    public function register()
    {
        
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

           $this->publishes([
            //发布门面,契约和与之对应的服务层
            __DIR__.'/../resources/Publish/Contract'=>app_path('Contract'),
            __DIR__.'/../resources/Publish/Facade/'=>app_path('Facade'),
            __DIR__.'/../resources/Publish/Service'=>app_path('Service'),
            __DIR__.'/../resources/Publish/Service/Facade'=>app_path('Service/Facade'),
            __DIR__.'/../resources/Publish/Service/Contract'=>app_path('Service/Contract'),
            //发布基础使用文档
            __DIR__.'/../../../Documents'=>base_path('Documents'),
            //发布错误视图
            __DIR__.'/../resources/views/errors/'=>resource_path('views/errors'),

           ],'init');
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
                \YouHuJun\LaravelInit\App\Console\Commands\BuildFacade::class,
                \YouHuJun\LaravelInit\App\Console\Commands\BuildFacadeService::class,
                \YouHuJun\LaravelInit\App\Console\Commands\CallFacadeService::class,
            ]);
        }
    }
}
