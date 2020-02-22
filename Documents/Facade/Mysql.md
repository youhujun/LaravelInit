# Mysql门面使用

[Mysql](#1)<span id="0">顶部</span>
<br/>
[1.1数据库单表操作](#1.1)
<br/>
[1.1.1 对单表添加一条或多条数据](#1.1.1)
<br/>
[1.1.2  对单表修改一条或多条数据](#1.1.2)
<br/>
[1.1.3  简单查询单表的数据](#1.1.3)
<br/>
[1.1.4  简单删除单表数据](#1.1.4)
<br/>
[1.2数据库多表操作 (多表联查)](#1.2)
<br/>
[1.2.1 多表联查](#1.2.1)
<br/>

## 说明:

1 这是自行封装门面的使用文档,是基于DB查询构造器封装

2注意表名的传递

3返回结果都是基于以下方式,操作完成后注意取值

例子:

```
//有误
$error = ['code'=>-10003,'msg'=>'数据传递格式有误'];
//失败
$ret = ['code'=>-10004,'msg'=>'添加失败!'];
//成功
$ret = ['code'=>0,'msg'=>'添加成功!','insert_id'=>$res];
```

4 example说明的是参数如何准备 ,参数最终只需要传递一个$data的数组类型参数即可

---

###  <span id="1">Mysql</span>[返回](#0)

使用前提:

```
use Mysql;
```

---

#### <span id="1.1">1.1数据库单表操作</span>[返回](#0)

##### <span id="1.1.1">1.1.1 对单表添加一条或多条数据</span>[返回](#0)

>```
>Mysql::increase($data);
>```
>
>说明:
>
>```
>/**
>	 * [incerase 对单表添加一条或多条数据的方法]
>	 * @param Array $data [传递参数是数组形式的 添加数据]
>     *	example :
>        $data['table_name'] = 'test';
>		$data['data'] = ['name'=>'***','phone'=>'***'];//第一种形式单条
>		|//第二种形式多条
>		[
>			['name'=>'***','phone'=>'***']
>			['name'=>'***','phone'=>'***']
>		];
>		|$data['has_id'] = 1;//可选参数 是否需要返回自增主键 !!!!!!注意当选择此参数以后,只能传递一维数组
>
>	 * @return [Array]       [返回添加结果 实际添加成功返回1]
>	    Array
>		(
>          [code] => 0
>          [msg] => 添加成功!
>          [insert_id] => 1
>         )	
>	 */
>```

---

##### <span id="1.1.2">1.1.2 对单表修改一条或多条数据</span>[返回](#0)

>```
>Mysql::update($data);
>```
>
>说明:
>
>```
>/**
>	 * [update 对单表修改一条或多条数据]
>	 * @param  Array  $data [传入的参数 数组形式 修改数据]
>	 *  example :
>	 *  $data['table_name'] = 'test';
>	 *  //!!!!注意 where对应的可以是一维数组也可以是二维数组 全部是and链接
>    	$data['where'] = [['id','>',1],['id','<',14],['id','!=','2']];
>    	//!!!!!!!!!!!!!!超级注意!!!!!!!!!! 如果需要多个orWhere ,需要写成三维数组的形式
>        $data['orWhere'] = [[['id','>',3],['id','<',13]],[['id','>',8],['id','<',11]]];
>        $data['whereIn'] = [5,6,8];
>    	$data['data'] = ['name'=>'嘎嘎'];
>    	$data['is_del'] = 1; //如果执行修改状态需要显示删除成功,可以添加此参数 默认参数为0
>	 * @return [Array]       [返回修改结果,实际修改成功返回1]
>	 */
>```

---

##### <span id="1.1.3">1.1.3 简单查询单表的数据</span>[返回](#0)

>```
>Mysql::select($data);
>```
>
>说明:
>
>```
>/**
>	 * [select 简单查询单表的数据]
>	 * @param  Array  $data [查询的条件数据]
>	 * example :
>	   $data['table_name'] = 'test';
>	   //以下均为可选参数 where条件同更新的where条件
>    	$data['where'] = [['id','>',1],['id','<',7]];
>    	$data['orWhere'] = [['id','>',8],['id','<',14]];
>    	$data['whereIn'] = [1,6,9];
>    	$data['select']  =['id','name'];
>    	$data['order'] =['id','asc'];
>    	$data['group'] = ['id'];
>    	$data['having']=['id','>','3'];
>    	//是否需要开启子查询
>    	$data['has_son'] = 1; 默认为0不开启
>	 * @return [Array]       [返回由对象组成的数组]  其中
>	 */
>```
>
>说明2:
>
>```
>example:
>注意子查询的查询条件的参数的设置(如,同名字段规避以及子查询之间的关系)
>//子查询
>$data['table_name'] = "user";
>$data['select'] = ['username','phone','id as uid'];
>//同更新处where条件,这里仅为示例
>$data['where'] = ['id','<','4'];
>$data['has_son'] = 1;
>
>$son = Mysql::select($data)['father'];
>
>$father = DB::table('user_union as un')->joinSub($son,'user',function($join)
>{
>	$join->on('uid','=','un.user_id');
>})->select('username','phone','un.userinfo_id as uiid','uid');
>
>$res = DB::table('userinfo as ui')->joinSub($father,'union',function($join)
>{
>	$join->on('uiid','=','ui.id');
>})->select('username','phone','uid','name','age')->get();
>```

---

##### <span id="1.1.4">1.1.4  简单删除单表数据</span>[返回](#0)

>```
>Mysql::delete($data);
>```
>
>说明:
>
>```
>/**
>	 * [delete 简单删除单表数据的方法]
>	 * @param  Array  $data [传入的参数数据]
>	 * example :
>	 *  $data['table_name'] = 'test';
>	 *  //同更新处where条件,这里仅为示例
>    	$data['where'] = [['id','>',1],['id','<',14],['id','!=','2']];
>        $data['orWhere'] = [[['id','>',3],['id','<',11]],[['id','>',8],['id','<',10]]];
>        //!!!!!!!!想执行删除操作,必须要传入参数,否则不会执行书删除操作 !!!提示::尽量不做删除操作,以修改状态为主
>        $data['is_yes'] = 1;
>        //如果需要清空表并重置表自增id 则必须要同时设置这两个可选参数,否则不会执行
>        $data['is_restart'] = 1;
>	 * @return [Array]       [返回数组,实际删除成功,返回删除条数,清空重置表以后返回空,所以自定义状态识别]
>	 */
>```

---

#### <span id="1.2">1.2数据库多表操作 (多表联查)</span>[返回](#0)

##### <span id="1.2.1">1.2.1 多表联查</span>[返回](#0)

>```
>Mysql::selectJoin($data);
>```
>
>说明:
>
>```
>/**
>	 * [selectJoin 多表联查]
>	 * @param  Array  $data [传入的参数数据]
>	 *example:
>	 *必传参数
>		$data['table_name'] = "user as u";
>		两表联查
>		$data['join'] = ['user_union as un','u.id','=','un.user_id'];
>		多表联查
>		$data['join'] = 
>		[
>			['user_union as un','u.id','=','un.user_id'],
>			['userinfo as ui','ui.id','=','un.userinfo_id'],
>		];
>		$data['order'] = ['u.id','desc'];
>		为保证查询条件不重名,尽量填写此参数
>		$data['select'] = ['u.id','u.username as 	  uname','u.phone','un.userinfo_id','ui.name','ui.age'];
>		$data['where'] = ['u.id','<','4'];
>		其他条件同单表查询
>	 * 
>	 * @return [Array]       [返回数组,实际返回查询的结果集]
>	 */
>```
>
>---

