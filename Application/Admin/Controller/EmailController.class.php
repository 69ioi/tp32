<?php
namespace Admin\Controller;
//use Think\Controller;

class EmailController extends CommonController
{
	// 发邮件方法send
	public function send()
	{
		// 判断请求的类型
		if (IS_POST) {
			// 接收数据
			$post = I('post.');
			// 实例化自定义模型
			$model = D('Email');
			// 调用具体类中的方法实现数据的保存
			$result = $model -> addData($post,$_FILES['file']);
			// 判断数据添加是否成功
			if ($result) {
				// 成功
				$this -> success('邮件发送成功',U('sendbox'),3);
			} else {
				// 失败
				$this -> error('邮件发送失败');
			}
			
		} else {
			// 查询可以发送邮件的收件人信息
			$data = M('User') -> field('id,truename') -> where('id != ' . session('id')) -> select();
			// 传递数据给模板
			$this -> assign('data',$data);
			// 展示模板
			$this -> display();
		}
	}

	// 发件箱方法sendbox
	public function sendbox()
	{
		// 查询出当前用户已经发送的数据
		// SELECT t1.*,t2.truename as truename FROM sp_email as t1 LEFT JOIN sp_user as t2 on t1.to_id = t2.id WHERE t1.from_id = 1;
		$data = M('Email') -> field('t1.*,t2.truename as truename') -> alias('t1') -> join('LEFT JOIN sp_user as t2 on t1.to_id = t2.id') -> where('t1.from_id = ' . session('id')) -> select();
		$this -> assign('data',$data);
		// 展示模板
		$this -> display();
	}

	// 收件箱方法recbox
	public function recbox()
	{
		// SELECT t1.*,t2.truename as truename FROM sp_email as t1 LEFT JOIN sp_user as t2 on t1.from_id = t2.id WHERE t1.to_id = 3;
		$data = M('Email') -> field('t1.*,t2.truename as truename') -> alias('t1') -> join('LEFT JOIN sp_user as t2 on t1.from_id = t2.id') -> where('t1.to_id = ' . session('id')) -> select();
		$this -> assign('data',$data);
		// 展示模板
		$this -> display();
	}

	// 下载方法download
	public function download($id)
	{
		// 接收id
		$id = I('get.id');
		// 查询信息
		$data = M('Email') -> find($id);
		// 下载图片(代码)
		$file = WORKING_PATH . $data['file'];
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="' . basename($file) . '"');
		header("Content-Length: " . filesize($file));
		readfile($file);
	}


	// 空操作方法
	public function _empty()
	{
		// 当访问到这个控制器中的方法不存在时，默认访问这个方法
		// 输出自定义的提示信息
		// echo "您好，您方法的 " . ACTION_NAME . ' 方法不存在';
		$this -> display('Empty/error');
	}


	// getContent方法
	public function getContent()
	{
		// 获取id
		$id = I('get.id');
		// 查询数据
		$data = M('Email') -> where("id = $id and to_id = " . session('id')) -> find();
		// 如果data为真则修改邮箱的状态
		if ($data['isread'] == 0) {
			// 修改状态
			M('Email') -> save(array('id' => $id, 'isread' => 1));
		}
		echo $data['content'];
	}

	// getCount方法
	public function getCount()
	{
		if (IS_AJAX) {
			// 实例化模型
			$model = M('Email');
			// 查询当前用户未读邮件数量
			$count = $model -> where("isread = 0 and to_id =" . session('id')) -> count();
			// 输出数字
			echo $count;
		}
	}
}