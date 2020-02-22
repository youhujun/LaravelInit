<?php
/*
 * @Descripttion: Mysql门面代理
 * @version: 1.0.0
 * @Author: YouHuJun
 * @Date: 2020-02-21 10:31:08
 * @LastEditors: YouHuJun
 * @LastEditTime: 2020-02-21 15:56:30
 */

namespace YouHuJun\LaravelInit\Facade\Data;

use  Illuminate\Support\Facades\Facade;
class Mysql extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Mysql';
    }
}
