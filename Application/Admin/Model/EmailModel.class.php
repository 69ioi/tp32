<?php
namespace Admin\Model;
use Think\Model;

class EmailModel extends Model
{
	// addData 
	public function addData($post,$file)
	{
		// 数据分为文件+字符
		if ($file['error'] == 0) {
			// 有文件需要处理
			$cfg = array('rootPath'	=>	WORKING_PATH . UPLOAD_ROOT_PATH);
			// 实例化上传类
			$upload = new \Think\Upload($cfg);
			// 开始上传
			$info = $upload -> uploadOne($file);
			// dump($info);die();
			// 判断上传结果
			if ($info) {
				// 上传成功，此时需要处理数据表中需要处理字段
				// filehasfile，filename
				$post['file'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
				$post['hasfile'] = '1';
				$post['filename'] = $info['name'];
			}
			// 补充字段
			$post['from_id'] = session('id');
			$post['addtime'] = time();
			// 数据的保存
			return $this -> add($post);	
		}
	}
}