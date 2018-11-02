<?php
namespace Admin\Model;
use Think\Model;

class DocModel extends Model
{
	public function saveData($post, $file)
	{
		// 实例化上传类
		// 先判断是否有文件需要处理
		if ($file['error'] == 0) {
			// 定义配置文件
			$cfg = array(
					// 配置上传文件
					'rootPath'	=>	WORKING_PATH.UPLOAD_ROOT_PATH,
				);
			// 处理上传文件，实例化上传类
			$upload = new \Think\Upload($cfg);
			// 开始上传
			$info = $upload -> uploadOne($file);
			// dump($info);
			if ($info) {
				// 补全剩余字段
				$post['filepath'] = UPLOAD_ROOT_PATH.$info['savepath'].$info['savename'];
				$post['filename'] = $info['name'];	//文件的原始名称
				$post['hasfile']  = 1;
				$post['addtime'] = time();
			}
		}
		// 将数据添加到数据库
		return $this -> add($post);
	}

	// 更新数据的保存
	public function updateData($post,$file)
	{
		// 判断文件是否需要处理，如果没有需要修改的文件，则不需要进行文件的相关数据存库
		if($file['error'] == 0) {
			// 有文件
			// 配置数组
			$cfg = array(
					'rootPath'	=>	WORKING_PATH.UPLOAD_ROOT_PATH,
				);
			// 实例化上传类
			$upload = new \Think\Upload($cfg);
			// 上传
			$info = $upload -> uploadOne($file);
			// dump($info);die;
			// 判断是否上传成功
			if ($info) {
				$post['filepath'] = UPLOAD_ROOT_PATH.$info['savepath'].$info['savename'];
				$post['filename'] = $info['name'];
				$post['hasfile'] = 1;
			}
		}
		// 写入数据
		return $this -> save($post);
	}
}