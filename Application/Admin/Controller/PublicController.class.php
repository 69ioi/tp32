<?php
namespace Admin\Controller;
use Think\Controller;

class PublicController extends Controller
{
	// 登录页面展示
	public function login()
	{
		// $str = $this->fetch();
		// echo $str;
		// dump($str);
		// 展示模板
		$this -> display();
	}

	// captcha方法
	public function captcha()
	{
		// 配置
		$cfg = array(
        		'useImgBg'  =>  false,           // 使用背景图片
				'fontSize'  =>  12,              // 验证码字体大小(px)
		        'useCurve'  =>  false,            // 是否画混淆曲线
		        'useNoise'  =>  false,            // 是否添加杂点	
		        'imageH'    =>  38,               // 验证码图片高度
		        'imageW'    =>  80,               // 验证码图片宽度
		        'length'    =>  4,               // 验证码位数
		        'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
			);
		// 实例化验证码类
		$verify = new \Think\Verify($cfg);
		// 输出验证码
		$verify -> entry();
	}

	// checkLogin方法
	public function checkLogin()
	{
		// 接收数据
		$post = I('post.');		//dump($post);
		// 验证验证码
		$verify = new \Think\Verify();
		// 验证
		$result = $verify -> check($post['captcha']);
		// 判断验证码是否正确
		if ($result) {
			// 验证码正确，验证用户名和密码
			$model = M('User');
			// 删除验证码元素
			unset($post['captcha']);
			// 查询
			$data = $model -> where($post) -> find();
			// 判断用户及密码是否正确
			if ($data) {
				// 正确，用户信息的持久化，即将数据保存到session,并跳转到后台首页
				session('id',$data['id']);
				session('username',$data['username']);
				session('role_id',$data['role_id']);

				// 跳转http://www.tp32.com/index.php/Admin/Public/login.html,http://www.tp32.com/index.php/Admin/Index/index.html
				$this -> success('登录成功@~@',U('Index/index'),1);
			} else {
				// 错误
				$this -> error('用户名或密码错误');
			}
		} else {
			// 验证码错误
			$this -> error('验证码错误','',2);
		}
	}

	// 退出方法
	public function logout()
	{
		// 清除session
		session(null);
		// 跳转到登录页面
		$this -> success('推出成功',U('login'),3);
	}
}