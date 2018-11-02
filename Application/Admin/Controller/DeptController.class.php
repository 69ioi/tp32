<?php
namespace Admin\Controller;
//use Think\Controller;

class DeptController extends CommonController
{
	// add方法
	public function add()
	{
		// 判断请求类型
		if (IS_POST) {
			// ThinkPHP提供了一个快速方法I方法，用于接收get，post提交的参数，用法I('参数')如I('get.id')，如果不想得到单个数据，可以将参数改为I('git.')，就可以得到get提交的所有以数组返回的数据
			// dump(I('post.'));
			// 接收提交的表单数据，以数组的形式
			// $post = I('post.');
			// 实例化模型
			$model = D('Dept');
			// 数据对象的创建
			$data = $model -> create();
			// dump($post);die();
			// 判断创建对象是否成功，即$model -> create();的返回值，如果为false表失败，如果返回数组则表是创建成功，在Model类中用了两个return来返回函数值
			// 通过创建数据对象的返回值来判断是否成功创建数据对象，如果失败的话，可以调用数据对象的内置方法getError来获取自动验证的错误信息，并输出到页面提示用户
			if(!$data) {
				// echo $model -> getError();exit();
				// dump($model -> getError());die();
				$this -> error($model -> getError());exit;
			}
			// dump($data);die();
			$result = $model -> add();
			// 判断是否提交成功
			if($result) {
				// 成功
				$this -> success('添加成功',U('showList'),3);
			} else {
				$this -> error('添加失败');
			}
		} else {
			// 查询顶级部门
			$model = M('Dept');
			$data = $model -> where('pid = 0') -> select();
			// 展示数据
			$this -> assign('data',$data);
			$this -> display();
		}
	}


	// showList展示模板
	public function showList()
	{
		/*// 实例化模型
		$model = M('Dept');
		// 统计记录数
		$count = $model -> count();
		// 实例化分页类
		$page = new \Think\Page($count,2);	//第一个参数为总记录数，第二个参数为每页显示几条记录
		// show方法生成页码URL链接
		$show = $page -> show();	//此方法返回很多a标签
		// limit查询
		$data = $model -> limit($page -> firstRow,$page -> listRows) -> order('sort asc') -> select();
		// 传递参数到模板
		$this -> assign('data',$data);*/
		// 实例化模型
		$model = M('Dept');
		// 查询数据
		$data = $model -> order('sort asc') -> select();
		// dump(	$data);die();
		// 二次遍历查询顶级部门
		foreach ($data as $key => $value) {
			// dump($value);die;
			// 查询pid对应的部门信息
			$info = $model -> find($value['pid']);
			// 只要保留其中的name值
			$data[$key]['deptname'] = $info['name'];
		}

		// 使用load方法载入文件
		load('@/tree');
		$data = getTree($data);
		$this -> assign('data',$data);
		// 展示模板
		$this -> display();
	}

	// edit方法
	public function edit()
	{
		if (IS_POST) {
			// 处理post请求
			$post = I('post.');
			// 实例化
			$model = M('Dept');
			// 保存操作
			$result = $model -> save($post);
			// 判断保持成功与否
			if ($result !== false) {
				// 保存成功
				$this -> success('保存成功',U('showList'),3);
			} else {
				// 保存失败
				$this -> error('保存失败');
			}
			
		} else {
			// 接收id
			$id = I('get.id');
			// 实例化模板
			$model = M('Dept');
			// 通过GET传递的参数id查询对应的记录并展示
			$data = $model -> find($id);
			// 查询全部的部门信息，给下拉类表使用
			$info = $model -> where("id != .$id") -> select();
			// 给模板传递参数
			$this -> assign('data',$data);
			$this -> assign('info',$info);
			// 展示模板
			$this -> display();
		}	
	}

	// del方法
	public function del()
	{
		// 接收参数
		$id = I('get.id');
		// 模型实例化
		$model = M('Dept');
		// 删除操作
		$result = $model -> delete($id);
		// 判断结果
		if ($result) {
			$this -> success('删除成功！');
		} else {
			$this -> error('删除失败！');
		}
	}





//----------------------------------------------------------------------------------------------

/*	
	// 展示实例化的结果
	public function shilihua()
	{
		// 普通实例化
		// $model = new \Admin\Model\DeptModel();
		// dump($model);
		// $model = D('Dept');
		// $model = D();
		// $model = M('Dept');
		$model = M();
		dump($model);
	}

	public function tianjia()
	{
		// 实例化模型
		$model = M('Dept');   // 使用基本的增删改查，可以直接使用父类模型
		// 声明一个关联数组
		$data = array(
				'name' => '财务部',
				'pid' => '0',
				'sort' => '2',
				'remark' => '这是财务部',
			);
		$result = $model -> add($data);
		$data = array(
				array(
					'name' => '公关部',
					'pid' => '0',
					'sort' => '3',
					'remark' => '这是公关部',
					),
				array(
					'name' => '总裁办',
					'pid' => '0',
					'sort' => '4',
					'remark' => '权力最高的部门',
					),
			);
		$model = M('Dept');
		// 批量添加
		$result = $model -> addAll($data);
		dump($result);
	}

	// save方法的使用
	public function xiugai()
	{
		// 实例化模型
		$model = M('Dept');
		// 修改操作
		$data = array(
				'id' => 2,
				'sort' => 22,
				'remark' => '今天发工资'
			);
		$result = $model -> save($data);
		dump($result);
	}


	// 
	public function chaxun()
	{
		// 实例化模型
		$model = M('Dept');
		// 查询全部记录，select函数的返回值是一个二维数组
		$result = $model -> select();
		// 查询单条记录，通过指定id来查询单条记录，$obj -> select('id')
		$result = $model -> select(3);
		// 查询多条记录，指定id集合
		$result = $model -> select('1,3');

		// find部分，这个查询函数返回的是一维数组
		// 查找表中的第一条记录（如果没指定参数，即id）
		$result = $model -> find();

		// 查询指定id的记录，通过参数来指定记录的id
		$result = $model -> find(3);
		dump($result);
	}


	// 删除操作
	public function shanchu()
	{
		$model = M('Dept');
		// $result = $model -> delete();
		// 删除指定id的记录
		$result = $model -> delete(11);
		// 通过指定多个id值来删除多条记录
		$result = $model -> delete('7,8,10,12,13');
		// 返回删除的记录条数
		dump($result);
		dump($model -> select());

		// 两者的结果一样，_sql()在之后的thinkpph版本中
		dump($model -> getLastSql());
		dump($model -> _sql());
	}

	// 性能统计
	public function tongji()
	{
		// 统计开始标记
		G('s');

		// 被统计的代码段
		for ($i=0; $i < 10000; $i++) { 
			echo $i;
		}

		// 结束标记
		G('e');

		echo '<hr/>';
		// 统计,第三个参数如果是数字，表示统计时间，单位是秒。如果是字符m，表示统计消耗的内存，单位是byt
		echo G('s','e',m);
	}
//----------------------------------------------------------------------------------------------
	// AR模式的添加操作
	public function test01()
	{
		// 第一个映射关系：类映射到表（类关联表）
		$model = M('Dept');
		// 第二个映射关系：属性映射到表字段
		$model -> name = '技术部';
		$model -> pid = '0';
		$model -> sort = '10';
		$model -> remark = '技术部门最重要';
		// 第三个映射；实例映射到记录
		$result = $model -> add();	//这里的add操作没有参数，在AR模式中
		dump($result);
	}

	// AR模式的的修改操作
	public function test02()
	{
		// 实例化模型
		$model = M('Dept');
		// 属性映射字段
		$model -> id = '6';		// 确定主键信息
		$model -> name = '财务部';
		$model -> remark = '掌管财务的部门';
		// 修改操作
		$result = $model -> save();
		dump($result);
	}


	// AR模式的删除操作
	// 在thinkphp中，AR模式的查询操作。这里的查询操作还是使用select和find方法
	public function test03()
	{
		// 实例化模型
		$model = M('Dept');
		// 指定主键信息
		$model -> id = '2';		// 属性可以是一个主键或多个主键 $model -> id = '2,4,6';
		dump($model -> delete($model -> id));
	}

	// AR模式的U,D操作也可以不指定主键信息(id)，当U,D操作之前有个find操作时
	public function test04()
	{
		$model = M('Dept');
		// 先执行查询操作
		$model -> find(1);
		// 指定要修改的属性的内容，之后在执行修改操作
		//$model -> pid = '1';
		//dump($model -> save());
		dump($model -> delete());
	}

	// where子查询
	public function test05()
	{
		$model = M('Dept');
		// 查询条件为id>4的记录
		$model -> where('id > 4');
		dump($model -> select());
	}

	// limit子查询，limit方法的参数可以是普通参数的形式，也可以是数组的形式
	public function test06()
	{
		$model = M('Dept');
		// 限制记录，第一种形式（查询前n条记录）limit(n);
		$model -> limit(4);

		// 第二种形式，查询带偏移量的
		$model -> limit('2,2');
		dump($model -> select());
	}

	// field字段限定查询，其参数是字符串或数组
	public function test07()
	{
		$model = M('Dept');
		$model -> field('id,name');
		dump($model -> select());
	}

	// order排序子查询，参数同样可以是字符串或数组
	public function test08()
	{
		$model = M('Dept');
		$model -> order('id desc');
		dump($model -> select());
	}

	// group分组子查询，参数为字符串或数组
	public function test09()
	{
		$model = M('Dept');
		$model -> field('name,count(*) as count');
		$model -> group('pid');
		dump($model -> select());
	}

	// 连贯操作
	public function test10()
	{
		$model = M('Dept');
		dump($model -> field('name,count(*) as count') -> group('pid') -> select());
	}

	// 统计操作count
	public function test11()
	{
		$model = M('Dept');
		dump($model -> count('id'));
	}

	// 某个字段的最大值max
	public function test12()
	{
		$model = M('Dept');
		dump($model -> max('sort'));
	}

	// 统计某字段的最小值min
	public function test13()
	{
		$model = M('Dept');
		dump($model -> min('sort'));
	}

	// 统计某字段的平均值avg
	public function test14()
	{
		$model = M('Dept');
		dump($model -> avg('sort'));
	}

	// 统计某字段的总和
	public function test15()
	{
		$model = M('Dept');
		dump($model -> sum('sort'));
	}


	// fetchSql方法，获取在连贯操作中执行的sql语句，解决了_sql和getLastSql方法的短处，因为这两个方法是获取最后一条执行成功的sql语句，如果最后一条sql语句执行失败，则这个函数就不会有返回结果，而fetchSql方法可以获取任意一条连贯操作的sql语句。
	public function test16()
	{
		$model = M('Dept');
		dump($model -> fetchSql(true) -> select());
		dump($model -> where('id = 4') -> fetchSql(true) -> select());
	}*/

}