<?php
/*
 * @Descripttion: 自定义助手函数
 * @Author: YouHuJun
 * @Date: 2020-02-20 11:25:39
 * @LastEditors: YouHuJun
 * @LastEditTime: 2021-05-23 18:20:49
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

 if(!function_exists('f'))
 {
     /**
      * @description: 过滤字符串中的标签
      * @param {string}
      * @return: void
      */
     function f($param)
     {
         return strip_tags($param);
     }
 }

 if(!function_exists('code'))
 {
     /**
      * @description: 请求返回
      * @param {array} $code ,配置文件code,定义
      * @param {array} $add,需要手动添加的数据
      * @return:
      */
     function code($code=[],$add=[])
     {
         $resArr = [];
         if(is_null($code)&&is_null($add))
         {
            $resArr = [];
         }
         else if(is_null($code)&&!is_null($add))
         {
            $resArr = $add;
         }
         else if(!is_null($code)&&is_null($add))
         {
            $resArr = $code;
         }
         else
         {
            $resArr = array_merge($code,$add);
         }
        return  $resArr;
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
    *  function  发起curl的post请求
    *
    * @param [string] $url 地址
    * @param array $headers 请求头数组
    $headers = ['X-TOKEN:'.$this->token,'X-VERSION:1.1.3','Content-Type:application/json','charset=utf-8'];
    * @param [请求数据] $data
    * @return //返回结果
    */
    function httpPost($url, $headers=[],$data=null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER,0);
        //设置请求头
        if(is_array($headers) && count($headers) > 0)
        {
           curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        
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
 * 处理时间开始
 */

if(!function_exists('showTime'))
{
    /**
     * Undocumented function 时间戳转字符串
     *
     * @param [int] $time 时间戳
     * @param boolean $bool 布尔 如果为真带时分秒
     * @return string
     */
    function showTime($time,$bool = false)
    {
       if($bool)
       {
           return date('Y-m-d H:i:s',$time);
       }
       else
       {
           return date('Y-m-d',$time);
       }
       
    }
}

/**
 * 处理时间结束
 */