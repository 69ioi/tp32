<?php
namespace Admin\Controller;
use Think\Controller;
class EmptyController extends Controller
{
	public function _empty()
	{
		// 当访问到这个控制器不存在时，默认访问这个控制器和这个方法
		// 输出自定义的提示信息
		// echo "您好，您方法的 " . CONTROLLER_NAME . ' 控制器不存在';
		$this -> display('Empty/error');
	}
}