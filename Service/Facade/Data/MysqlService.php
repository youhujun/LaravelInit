<?php
/*
 * @Descripttion: mysql门面服务
 * @version: 1.0.0
 * @Author: YouHuJun
 * @Date: 2020-02-21 10:32:13
 * @LastEditors: YouHuJun
 * @LastEditTime: 2020-02-21 15:57:11
 */
namespace YouHuJun\LaravelInit\Service\Facade\Data;

use DB;
use Illuminate\Support\Collection as Col;

class MysqlService
{
  //接收参数容器
  protected $params;
  //表名
  protected $table_name;
  //添加数据容器
  protected $data;
  //是否获取自增主键状态
  protected $has_id;
  //是否开启子查询
  protected $has_son;
  //多表联查容器
  protected $join;
  //where条件
  protected $where;
  //orwhere条件
  protected $orWhere;
  //whereIn 条件
  protected $whereIn;
  //查询字段
  protected $select;
  //分组
  protected $group;
  //排序
  protected $order;
  //限定
  protected $having;
  //判断是否为更新删除(修改数据是否显示的状态)
  protected $is_del;
  //判断是否删除,真实删除
  protected $is_yes;
  //判断是否清空,重置表
  protected $is_restart;
 
  //初始化表名设置
  private function setBase(Array $data)
  {
     $this->params = func_get_arg(0);
 
     //处理表名参数
     if(isset($this->params['table_name']))
     {
        $this->table_name =$this->params['table_name'];
     }
     else
     {
                 
        $error = code(config('code.mysql.error.90001'));
        return $error;
     }
 
  }
 
  //公共设置where 和orWhere 条件
  private function setWhere()
  {
     //处理where
     if(isset($this->params['where']) && is_array($this->params['where']))
     {
        $this->where = $this->params['where'];
     }
     else
     {
        $this->where = [];
     }
 
     //处理orWhere条件
     if(isset($this->params['orWhere']) && is_array($this->params['orWhere']))
     {
 
        $this->orWhere = $this->params['orWhere'];
     }
     else
     {
        $this->orWhere = [];
     }
 
     //处理whereIn条件
     if(isset($this->params['whereIn']) && is_array($this->params['whereIn']))
     {
 
        $this->whereIn = $this->params['whereIn'];
     }
     else
     {
        $this->whereIn = [];
     }
  }
 
  /**
   * [setIncrease 处理增加的数据]
   */
  private function setIncrease()
  {
     //处理添加数据
     if(isset($this->params['data'])&&is_array($this->params['data']))
     {
        $this->data = $this->params['data'];
 
     }
     else
     {
        $error = code(config('code.mysql.error.90002'));
        return $error;
     }
     //判断是否获取添加id
     if(isset($this->params['has_id']))
     {
        $this->has_id = $this->params['has_id'];
     }
     else
     {
        $this->has_id = 0;
     }
  }
 
  /**
   * [setUpdate 处理更新的数据]
   */
  private function setUpdate()
  {
 
     $this->setWhere();
     //处理更新数据
     if(isset($this->params['data'])&&is_array($this->params['data']))
     {
        $this->data = $this->params['data'];
     }
     else
     {
        $error = code(config('code.mysql.error.90003'));
        return $error;
     }
     //处理是否为更新删除操作
     if(isset($this->params['is_del']))
     {
        $this->is_del = $this->params['is_del'];
     }
     else
     {
        $this->is_del = 0;
     }
  }
 
  /**
   * [setSelect 处理查询的数据]
   */
  private function setSelect()
  {
 
     $this->setWhere();
     //查询字段条件
     if(isset($this->params['select'])&&is_array($this->params['select'])&&count($this->params['select']))
     {
        $this->select = $this->params['select'];
     }
     else
     {
        $this->select = '*';
     }
 
     //分组条件
     if(isset($this->params['group'])&&is_array($this->params['group']))
     {
        $this->group = $this->params['group'];
     }
 
     //排序条件
     if(isset($this->params['order'])&&is_array($this->params['order'])&&count($this->params['order'])==2)
     {
        $this->order = $this->params['order'];
     }
     else
     {
        //默认降序排序
        $this->order = ['id','desc'];
     }
 
     //限定条件
     if(isset($this->params['having'])&&is_array($this->params['having'])&&count($this->params['having'])==3)
     {
        $this->having = $this->params['having'];
     }
 
     //是否开启子查询
     if(isset($this->params['has_son']))
     {
        $this->has_son = $this->params['has_son'];
     }
     else
     {
        $this->has_son = 0;
     }
  }
 
  /**
   * [setSelectJoin 处理多表联查]
   */
  private function setSelectJoin()
  {
     if (isset($this->params['join'])&&is_array($this->params['join']))
     {
        $this->join = $this->params['join'];
     }
     else
     {
        $error = code(config('code.mysql.error.90011'));
        return $error;
     }
 
     $this->setSelect();
 
  }
  /**
   * [setDelete 处理删除数据]
   */
  private function setDelete()
  {
     $this->setWhere();
     //处理是否确认删除
     if(isset($this->params['is_yes']))
     {
        $this->is_yes = $this->params['is_yes'];
     }
     else
     {
        $this->is_yes = 0;
     }
     //处理是否确认重置清空
     if(isset($this->params['is_restart']))
     {
        $this->is_restart = $this->params['is_restart'];
     }
     else
     {
        $this->is_restart = 0;
     }
  }
 
  /*====================================之上设置部分++++++++之下执行部分====================================*/
  /**
   * [doWhere 公共执行where和orWhere]
   * @param  [connection] $query [根据表名建立的链接]
   * @return [void]        [链式调用完毕where和orWhere]
   */
  protected function doWhere($query)
  {
     //判断执行where
     if(count($this->where))
     {
        if(array_level($this->where)==1)
        {
           if(count($this->where)==2)
           {
              $query ->where("{$this->where[0]}","{$this->where[1]}");
           }
           else if(count($this->where)==3)
           {
              $query ->where("{$this->where[0]}","{$this->where[1]}","{$this->where[2]}");
           }
           else
           {
               
               $error = code(config('code.mysql.error.90021'));

               return $error;
           }
        }
        else
        {
           $query ->where($this->where);
        }
     }
     //判断执行orWhere
     if(count($this->orWhere))
     {
        if(array_level($this->orWhere)==1)
        {
           if(count($this->orWhere)==2)
           {
              $query ->orWhere("{$this->orWhere[0]}","{$this->orWhere[1]}");
           }
           else if(count($this->orWhere)==3)
           {
              $query ->orWhere("{$this->orWhere[0]}","{$this->orWhere[1]}","{$this->orWhere[2]}");
           }
           else
           {
               
               $error = code(config('code.mysql.error.90022'));
             
               return $error;
           }
        }
        else if(array_level($this->orWhere)==2)
        {
           $query ->orWhere($this->orWhere);
        }
        else if(array_level($this->orWhere)==3)
        {
           foreach ($this->orWhere as $k => $v)
           {
              $query ->orWhere($this->orWhere[$k]);
           }
        }
        else
        {
           $error = code(config('code.mysql.error.90023'));
           return $error;
        }
     }
 
     //判断执行whereIn
     if(count($this->whereIn)) 
     {
       if(array_level($this->whereIn)==2)
       {  
          if(count($this->whereIn[1])<1)
          {
            $error = code(config('code.mysql.error.90024'));
            return $error;
          }
          else
          {
            $query ->whereIn("{$this->whereIn[0]}",$this->whereIn[1]);
          }
          
       }
       else
       {
          $error = code(config('code.mysql.error.90025'));
          return $error;
       }
     }
  }
 
  /**
   * [incerase 对单表添加一条或多条数据的方法]
   * @param Array $data [传递参数是数组形式的 添加数据]
   *  example :
   *     $data['table_name'] = 'test';
   *   $data['data'] = ['name'=>'***','phone'=>'***'];//第一种形式单条
   *   |//第二种形式多条
   *   [
   *      ['name'=>'***','phone'=>'***']
   *      ['name'=>'***','phone'=>'***']
   *   ];
   *   |$data['has_id'] = 1;//可选参数 是否需要返回自增主键 !!!!!!注意当选择此参数以后,只能传递一维数组
   * @return [Array]       [返回添加结果 实际添加成功返回1]
   */
  public function increase(Array $data)
  {
     $error=$this->setBase($data);
     if($error) return $error;
     $error = $this->setIncrease();
 
     if($error) return $error;
 
     $query = q($this->table_name);
 
     if($this->has_id)
     {
        if(count($this->data) !== count($this->data,1))
        {
           $error = code(config('code.mysql.error.90004'));
           return $error;
        }
 
        $res = $query->insertGetId($this->data);

        $ret =  code(config('code.mysql.increase'),['insert_id'=>$res]);

        if(!$res)
        {
           $ret = code(config('code.mysql.error.90005'));
        }
     }
     else
     {
        $res = $query->insert($this->data);

        $ret = code(config('code.mysql.increase'));

        if(!$res)
        {
           $ret = code(config('code.mysql.error.90006'));
        }
     }
 
     return $ret;
  }
 
  /**
   * [update 对单表修改一条或多条数据]
   * @param  Array  $data [传入的参数 数组形式 修改数据]
   *  example :
   *  $data['table_name'] = 'test';
   *  //!!!!注意 where对应的可以是一维数组也可以是二维数组 全部是and链接
   * $data['where'] = [['id','>',1],['id','<',14],['id','!=','2']];
   * //!!!!!!!!!!!!!!超级注意!!!!!!!!!! 如果需要多个orWhere ,需要写成三维数组的形式
   *   $data['orWhere'] = [[['id','>',3],['id','<',13]],[['id','>',8],['id','<',11]]];
   *  批量更新
   *  $user['whereIn'] = ['id',$array_id];
   * $data['data'] = ['name'=>'嘎嘎'];
   * $data['is_del'] = 1; //如果执行修改状态需要显示删除成功,可以添加此参数 默认参数为0
   * @return [Array]       [返回修改结果,实际修改成功返回1]
   */
  public function update(Array $data)
  {
     //设置
     $error = $this->setBase($data);
     if($error) return $error;
     $error = $this->setUpdate();
     if($error) return $error;
     //执行
     $query = q($this->table_name);
     $error = $this->doWhere($query);
     if($error) return $error;
 
     $res = $query->update($this->data);
 
 
     if($res)
     {
        $ret = code(config('code.mysql.increase'));
     }
     else
     {
        $ret = code(config('code.mysql.error.90007'));
     }
 
     return $ret;
  }
 
  
  /**
   * [select 简单查询单表的数据]
   * @param  Array  $data [查询的条件数据]
   * example :
  * $data['table_name'] = 'test';
  * //以下均为可选参数 where条件同更新的where条件
  * $data['where'] = [['id','>',1],['id','<',7]];
  * $data['orWhere'] = [['id','>',8],['id','<',14]];
  * $data['select']  =['id','name'];
  * $data['order'] =['id','asc'];
  * $data['group'] = ['id'];
  * $data['having']=['id','>','3'];
  * //是否需要开启子查询
  * $data['has_son'] = 1; 默认为0不开启
   * @return [Array]       [返回由对象组成的数组]
   */
  public function select(Array $data)
  {
     //设置
     $error=$this->setBase($data);
     if($error) return $error;
     $this->setSelect();
 
     //执行
     $query = q($this->table_name);
 
     $error = $this->doWhere($query);
     if($error) return $error;
 
     if(isset($this->group)&&!empty($this->group)&&count($this->group))
     {
        $query->groupBy($this->group);
     }
 
     $query->orderBy("{$this->order[0]}","{$this->order[1]}");
 
     if(isset($this->having)&&!empty($this->having))
     {
        $query->having("{$this->having[0]}","{$this->having[1]}","{$this->having[2]}");
     }
 
     //父查询
     $father = $query->select($this->select);
     //查询结果
     $res = $father->get();
 
     if($res)
     {
        //判断是否需要开启子查询
        if(isset($this->has_son)&&$this->has_son == 1)
        {  
           $ret = code(config('code.mysql.update'),['data'=>$res,'father'=>$father]);
        }
        else
        {
           $ret = code(config('code.mysql.update'),['data'=>$res]);
        }
 
     }
     else
     {
        $ret = code(config('code.mysql.error.90008'));
     }
 
     return $ret;
  }
 
  /**
   * [delete 简单删除单表数据的方法]
   * @param  Array  $data [传入的参数数据]
   * example :
   *  $data['table_name'] = 'test';
   *  //同更新where条件
   * $data['where'] = [['id','>',1],['id','<',14],['id','!=','2']];
   *   $data['orWhere'] = [[['id','>',3],['id','<',11]],[['id','>',8],['id','<',10]]];
   *   //!!!!!!!!想执行删除操作,必须要传入参数,否则不会执行书删除操作 !!!提示::尽量不做删除操作,以修改状态为主
   *   $data['is_yes'] = 1;
   *   //如果需要清空表并重置表自增id 则必须要同时设置这两个可选参数,否则不会执行
   *   $data['is_restart'] = 1;
   * @return [Array]       [返回数组,实际删除成功,返回删除条数,清空重置表以后返回空,所以自定义状态识别]
   */
  public function delete(Array $data)
  {
     //设置
     $error = $this->setBase($data);
 
     if($error) return $error;
 
     $this->setDelete();
     //执行
     $query = q($this->table_name);
     //必须同时具备两个参数才可以清空重置表
     if(!$this->is_yes&&!$this->is_restart)
     {
        $ret = code(config('code.mysql.error.90009')); 
     }
     //清除重置表
     if($this->is_restart&&$this->is_yes)
     {
         $status = 0;
         $res = $query->truncate();
         $status = 1;
 
         if($status)
         {
            $ret = code(config('code.mysql.restart'),['status'=>$status]);
         }
         else
         {
            $ret = code(config('code.mysql.error.90000'),['status'=>$status]);
         }
 
     }
 
     //删除操作
     if ($this->is_yes&&!$this->is_restart)
     {
         $error = $this->doWhere($query);
         if($error) return $error;
         $res = $query->delete();
 
         if($res)
         {
            $ret = code(config('code.mysql.delete'),['numbers'=>$res]);
         }
         else
         {
           $ret = code(config('code.mysql.error.90010')); 
         }
     }
 
     return $ret;
  }
 
  /**
   * [selectJoin 多表联查]
   * @param  Array  $data [传入的参数数据]
   *example:
   *必传参数
   * $data['table_name'] = "user as u";
   * 两表联查
   * $data['join'] = ['user_union as un','u.id','=','un.user_id'];
   * 多表联查
   * $data['join'] =
   * [
   *    ['user_union as un','u.id','=','un.user_id'],
   *    ['userinfo as ui','ui.id','=','un.userinfo_id'],
   * ];
   * $data['order'] = ['u.id','desc'];
   * 为保证查询条件不重名,尽量填写此参数
   * $data['select'] = ['u.id','u.username as uname','u.phone','un.userinfo_id','ui.name','ui.age'];
   * $data['where'] = ['u.id','<','4'];
   * 其他条件同单表查询
   *
   * @return [Array]       [返回数组,实际返回查询的结果集]
   */
  public function selectJoin(Array $data)
  {
     //设置
     $error=$this->setBase($data);
     if($error) return $error;
 
     $error = $this->setSelectJoin();
      if($error) return $error;
 
      //执行
     $query = q($this->table_name);
 
     //执行联查
     if(is_array($this->join))
     {
        if(array_level($this->join)==1)
        {
           if(count($this->join)==4)
           {
             $query->join($this->join[0], $this->join[1],$this->join[2],$this->join[3]);
           }
           else
           {
              $error = code(config('code.mysql.error.90012')); 
              return $error;
           }
 
        }
        else if(array_level($this->join)==2)
        {
           foreach ($this->join as $k => $v)
           {
              if(count($v)==4)
              {
                $query->join($v[0], $v[1],$v[2],$v[3]);
              }
              else
              {
               $error = code(config('code.mysql.error.90013')); 
                return $error;
              }
           }
        }
        else
        {
           $error = code(config('code.mysql.error.90014')); 
           return $error;
        }
     }
     else
     {
        $error = code(config('code.mysql.error.90015')); 
        return $error;
     }
 
     $error = $this->doWhere($query);
     if($error) return $error;
      $query->select($this->select);
 
     if(isset($this->group)&&!empty($this->group)&&count($this->group))
     {
        $query->groupBy($this->group);
     }
 
     $query->orderBy("{$this->order[0]}","{$this->order[1]}");
 
     if(isset($this->having)&&!empty($this->having))
     {
        $query->having("{$this->having[0]}","{$this->having[1]}","{$this->having[2]}");
     }
 
     $res = $query->get();
 
     if($res)
     {
        $ret = code(config('code.mysql.select'),['data'=>$res]); 
     }
     else
     {
        $ret = code(config('code.mysql.error.90016')); 
     }
 
     return $ret;
  }
}


