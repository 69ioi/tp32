<?php
namespace Admin\Controller;
//use Think\Controller;

class KnowledgeController extends CommonController
{
	public function add()
	{
		// 判断请求类型
		if (IS_POST) {
			// 处理请求
			$post = I('post.');
			// 实例化模型
			$model = D('Knowledge');
			// 数据的保存
			$result = $model -> addData($post, $_FILES['thumb']);
			// 判断结果
			if ($result) {
				// 添加成功
				$this -> success('添加成功',U('showList'),3);
			} else {
				// 添加失败
				$this -> error('添加失败');
			}
			
		} else {
			// 展示模板
			$this -> display();
		}
	}


	public function showList()
	{
		// 获取数据
		$data = D('Knowledge') -> select();
		// 将数据传递给模板
		$this -> assign('data',$data);
		// 展示模板
		$this -> display();
	}

	// download方法
	public function download()
	{
		// 获取id
		$id = I('get.id');
		// 查询数据信息，将对应的图片位置查出来
		$data = D('Knowledge') -> find($id);
		// 下载图片
		$file = WORKING_PATH . $data['thumb'];
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="' . basename($file) . '"');
		header("Content-Length: " . filesize($file));
		readfile($file);
	}

	// getContent方法
	public function getContent()
	{
		// 获取id
		$id = I('get.id');
		// 查询数据
		$data = M('Knowledge') -> find($id);
		echo $data['content'];
	}
}