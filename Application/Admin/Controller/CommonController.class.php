<?php
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller
{
	// php内置的构造方法
	// public function __construct()
	// {
	// 	// 构造父类
	// 	parent::__construct();
	// 	// echo 'hello world!';
	// }

	// ThinKPHP提供构造方法
	public function _initialize()
	{
		$id = session('id');
		// 判断用户是否登录
		if (empty($id)) {
			// 如果没有登录，跳转到登录页面
			// $this -> error('请登录...',U('Public/login'),3);exit;
			$url = U('Public/login');
			echo "<script>top.location.href='$url'</script>";exit;
		}

		// RBAC部分
		$role_id = session('role_id');		// 获取当前的角色id
		$rbac_role_auths = C('RBAC_ROLES_AUTHS');	// 获取全部的用户组的权限
		$currRoleAuth = $rbac_role_auths[$role_id];	// 获取当前用户的权限

		// 使用常量获取当前当前路由中的的控制器名和方法名
		$controller = strtolower(CONTROLLER_NAME);
		$action = strtolower(ACTION_NAME);

		// 判断用户是否具有权限
		if ($role_id > 1) {
			// 当用户不是超级管理员的时候进行权限判断
			if (!in_array($controller.'/'.$action, $currRoleAuth) && !in_array($controller.'/*',$currRoleAuth)) {
				// 用户没有权限
				$this -> error('您没有权限',U('Index/home'));exit;
			}
		}
	}
}