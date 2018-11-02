<?php
namespace Admin\Controller;
//use Think\Controller;

class DocController extends CommonController
{
	// showList方法
	public function showList()
	{
		// 实例化模板
		$model = M('Doc');
		// 查询数据
		$data = $model -> select();
		// 传递数据到模板
		$this -> assign('data',$data);
		// 展示模板
		$this -> display();
	}

	// add方法
	public function add()
	{
		// 判断请求类型
		if (IS_POST) {
			// 处理提交
			$post = I('post.');
			// 接收数据
			$model = D('Doc');
			$result = $model -> saveData($post, $_FILES['file']);
			// 判断保存结果
			if ($result) {
				$this -> success('添加成功',U('showList'),3);
			} else {
				$this -> error('添加失败');
			}
			
		} else {
			// 展示模板
			$this -> display();
		}
	}

	// download方法文件下载
	public function download()
	{
		// 接收参数
		$id = I('get.id');
		// 查询数据
		$data = M('Doc') -> find($id);
		// 下载代码
		$file = WORKING_PATH . $data['filepath'];
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="' . basename($file) . '"');
		header("Content-Length: " . filesize($file));
		readfile($file);
	}

	//showContent方法
	public function showContent()
	{
		// 接收id
		$id = I('get.id');
		// 查询数据
		$data = M('Doc') -> find($id);
		// 输出内容，并且还原被转换的字符
		echo htmlspecialchars_decode($data['content']);
	}

	// edit方法
	public function edit()
	{
		// 判断是展示修改页面还是提交保存修改后的页面
		if (IS_POST) {
			// 处理提交的数据
			$post = I('post.');
			// 实例化自定义模型
			$model = D('Doc');
			// 调用updateData方法实现数据的保存
			$result = $model -> updateData($post,$_FILES['file']);
			// 判断返回值
			if ($result) {
				// 保存成功
				$this -> success('保存成功',U('showList'),3);
			} else {
				// 保存失败
				$this -> error('保存失败');
			}
			
		} else {
			// 接收id
			$id = I('get.id');
			// 查询数据
			$data = M('Doc') -> find($id);
			// 变量分配
			$this -> assign('data',$data);
			// 展示模板
			$this -> display();
		}
	}
}