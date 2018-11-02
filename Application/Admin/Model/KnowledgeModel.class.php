<?php
namespace Admin\Model;
use Think\Model;

class KnowledgeModel extends Model
{
	// addData方法
	public function addData($post, $file)
	{
		// 是否有文件需要处理
		if ($file['error'] == 0) {
			// 配置数组
			$cfg = array(
					'rootPath'	=>	WORKING_PATH . UPLOAD_ROOT_PATH,
				);
			// 实例化上传类
			$upload = new \Think\Upload($cfg);
			// 上传文件
			$info = $upload -> uploadOne($file);
			// dump($info);die;
			// 判断上传是否成功，成功则补全字段
			if ($info) {
				// 将图片位置保存到数据库
				$post['picture'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
				// 制作缩略图
				// 1，实例化图像制作类
				$image = new \Think\Image();
				// 2，打开图片，传递图像的路径
				$image -> open(WORKING_PATH . $post['picture']);
				// 3，制作缩略图，等比缩放
				$image -> thumb(100,100);
				// 4，保存图片
				$image -> save(WORKING_PATH . UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb' . $info['savename']);
				// 6，补全thumb字段
				$post['thumb'] = WORKING_PATH . UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb' . $info['savename'];
			}			
		}
		// 补全字段addtime
		$post['addtime'] = time();
		// dump($post);die;
		// 将数据保存到数据库
		return $this -> add($post);
		
	}
}