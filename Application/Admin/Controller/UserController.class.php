<?php
namespace Admin\Controller;
//use Think\Controller;

class UserController extends CommonController{
	// add方法
	public function add()
	{
		// 判断请求的类型
		if (IS_POST) {
			// 处理表单提交
			$model = M('User');
			// 创建数据对象
			$data = $model -> create();
			// 添加时间字段
			$data['addtime'] = time();
			// dump($data);die();
			// 保存到数据表里面
			$result = $model -> add($data);
			// 判断是否保存成功
			if ($result) {
				// 保存成功
				$this -> success('添加成功',U('showList'),3);
			} else {
				// 保存失败
				$this -> error('添加失败');
			}
			
		} else {
			// 实例化模型
			$data = M('Dept') -> field('id,name') -> select();
			// 给模板设置参数
			$this -> assign('data',$data);
			// 展示模板
			$this -> display();
		}
		
	}

	// showList
	public function showList()
	{
		// 展示数据
		// 实例化模板
		$model = M('User');
		// 分页第一步：查询总的记录数
		$count = $model -> count();
		// 分页第二步：实例化分页类
		$page = new \Think\Page($count,4);		// 每页显示10条数据
		// 分页第三步：定制分页按钮的提示文字
		$page -> rollPage = 3;
		$page -> lastSuffix = false;
		$page -> setConfig('prev','上一页');
		$page -> setConfig('next','下一页');
		$page -> setConfig('last','末页');
		$page -> setConfig('first','首页');
		// 分页第四部：使用show方法生成URL
		$show  = $page -> show();
		// 分页第五步：展示数据
		$data = $model -> limit($page -> firstRow,$page -> listRows) -> select();
		// 分页第六步：传递数据给模板
		$this -> assign('first',$page -> firstRow +1);
		$this -> assign('last',$page -> firstRow + $page -> listRows);
		$this -> assign('count',$count);
		$this -> assign('show',$show);
		$this -> assign('data',$data);
		// 分页第七步：展示模板
		$this -> display();
	}

	// edit编辑方法
	public function edit()
	{
		if (IS_POST) {
			// 接收post提交的参数
			$post = I('post.');
			// 将修改的数据插入数据表中
			$model = M('User');
			// 保存操作
			$result = $model -> save($post);
			// 判断是否保存成功
			if ($result !== false) {
				// 保存成功
				$this -> success('保存成功',U('showList'),3);
			} else {
				// 保存失败
				$this -> error('保存失败');
			}
			
		} else {
			// 实例化模板
			$model = M('User');
			// 查询出id值对应的数据
			$data = $model -> find($_GET['id']);
			// 实例化Dept模型，model1
			$model1 = M('Dept');
			// 查询表的部门信息，给表的下拉菜单使用
			$info = $model1 -> select();
			// 将id对应的数据传递给模板
			$this -> assign('data',$data);
			// 将Dept模型中的所有部门信息传递给模板
			$this -> assign('info',$info);
			$this -> display();
		}		
	}

	// del方法
	public function del()
	{
		// 接收参数
		$id = I('get.id');
		// 模型实例化
		$model = M('User');
		// 删除操作
		$result = $model -> delete($id);
		// 判断结果
		if ($result) {
			$this -> success('删除成功！');
		} else {
			$this -> error('删除失败！');
		}
	}

	// charts展示图表
	public function charts()
	{
		// 实例化模型
		$model = M();
		// $sql = 'select t2.name as deptname,count(*) as count from sp_user as t1,sp_dept as t2 where t1.dept_id = t2.id group by deptname';
		$data = $model -> field('t2.name as deptname,count(*) as count') -> table('sp_user as t1,sp_dept as t2') -> where('t1.dept_id = t2.id') -> group('deptname') -> select();
		// dump($data);die;
		$str = '';
		// 循环遍历数组，拼接成字符串传递到模板中去，这里不能直接用assign函数直接传递参数
		foreach($data as $key => $value) {
			$str .= "['".$value['deptname']."',".$value['count']."],";
		}
		// 去除最后的逗号
		$str = "[". rtrim($str,',') ."]";
		// echo $str;
		// 将参数传递给模板
		$this -> assign('str',$str);
		// 展示模板
		$this -> display();
	}
}