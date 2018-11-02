<?php
namespace Admin\Model;
use Think\Model;

class DeptModel extends Model
{
	// 开启批量认证
	// protected $patchValidate	=	true;

	// 字段映射定义
	protected $_map				=	array(
			// 映射规则
			// 键是表单中的name值 = 值是数据表中的字段名
			'abc'		=>	'name',
			'wasd'		=>	'sort',
		);

	// 自动验证定义
	protected $_validate        =   array(
			// 针对部门名称的验证规则，验证该字段是否为空
			// array('name','require','部门信息不能为空'),
			// 验证这个字段是否已经存在
			// 这里的唯一性判断，是thinkphp内部自动验证，即去数据库里面查出并比对验证
			array('name','','部门名称已存在',0,'unique'),
			// 排序字段的验证，判断是否为数字
			// array('sort','number','排序必须是数字'),
			// 使用php内置函数或者自定义的函数（自定义验证规则）来验证排序是否为数字，即第二个参数（验证规则）为函数名，自定义可以在thinkphp函数库中定义，也可以在本类中定义，这里必须有第五个参数，即附加规则
			array('sort','is_numeric','排序必须是数字',0,'function'),
		);
}
