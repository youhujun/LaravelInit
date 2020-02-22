<?php
/*
 * @Descripttion: 自定义助手函数
 * @Author: YouHuJun
 * @Date: 2020-02-20 11:25:39
 * @LastEditors: YouHuJun
 * @LastEditTime: 2020-02-21 16:07:49
 */

 if(!function_exists('p'))
 {
     /**
      * @description: 打印函数
      * @param {mixed} 
      * @return: void
      */
     function p($param):void
     {
         echo "<pre>";
         print_r($param);
         echo "</pre>";
     }
 }


/**
 * 请求处理 ++++++++++++++++++++++++++++++++++++++++++
 */

if(!function_exists('httpGet'))
{
   /**
    * @description: 发送get请求
    * @param {uri} url是请求地址 
    * @return: mixed 请求的结果
    */ 
   function httpGet($url) 
   {
       $curl = curl_init();
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
       curl_setopt($curl, CURLOPT_TIMEOUT, 10 );
       curl_setopt($curl, CURLOPT_URL, $url );
       $res = curl_exec($curl);
       curl_close($curl);
       return $res;
   }
}
if(!function_exists('httpPost'))
{
   /**
    * @description: 发送post请求
    * @param {url}请求地址 
    * @param {data} 请求数据
    * @return: mixed 请求结果
    */ 
   function httpPost($url, $data) 
   {
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL,$url);
       curl_setopt($ch, CURLOPT_HEADER,0);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
       if(!empty($data)){
           curl_setopt($ch, CURLOPT_POST, 1);
           curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       }
       $res = curl_exec($ch);
       curl_close($ch);
       return $res;
   }
}
/**
 * 请求处理结束--------------------------------------------------

 */


/**
 * 处理数据库++++++++++++++++++++++++++++++++++++++++++
 */
 
if (!function_exists('q')) {
    /**
     * [q 使用DB与指定表建立连接]
     * @param  String $table_name [数据库表名]
     * @return [obj]             [返回建立的表连接]
     */
    function q(String $table_name)
    {
        $query = DB::table($table_name);
 
        return $query;
    }
}
 
/**
 * 协助处理数组++++++++++++++++++++++++++++
 */
 
if (!function_exists('array_level')) {
    /**
     * [array_level 计算数组的维度 需要结合total函数]
     * @param  Array  $arr [需要计算的数组]
     * @return [int]      [返回数组的维度]
     */
    function array_level(array $arr)
    {
        $al = [0];
        total($arr, $al);
        return max($al);
    }
}
if (!function_exists('total')) {
    /**
     * [total 辅助 array_level计算数组维度 辅助array_level函数]
     * @param  [array]  $arr   [传入的数组]
     * @param  [array引用参数]  &$al   [传入的值]
     * @param  integer $level [统计的数组维度]
     * @return [void]         [无返回值]
     */
    function total($arr, &$al, $level = 0)
    {
        if (is_array($arr)) {
 
            $level++;
 
            $al[] = $level;
 
            foreach ($arr as $v) {
                total($v, $al, $level);
            }
        }
    }
}
/**
 * 协助处理数组结束--------------------------
 */
/**
 * 处理数据库结束-------------------------------------------------------
 */