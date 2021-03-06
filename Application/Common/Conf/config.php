<?php
return array(
	//'配置项'=>'配置值'
	'TMPL_PARSE_STRING' => array(
			'__ADMIN__' => __ROOT__.'/Public/Admin',
		),
	'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'db_oa',     // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '',          // 密码
    'DB_PORT'               =>  '3306',      // 端口
    'DB_PREFIX'             =>  'sp_',       // 数据库表前缀

    // 显示跟踪信息
    'SHOW_PAGE_TRACE'       =>  'true',      // 默认为false，开启则改写为true
    // 动态加载文件
    'LOAD_EXT_FILE'         =>  'info',

    // RBAC权限数据信息
    'RBAC_ROLES'            =>  array(
                                1   =>  '高层管理',
                                2   =>  '中层领导',
                                3   =>  '普通职员',
                            ),

    //权限数组（关联角色数组）
    'RBAC_ROLES_AUTHS'      =>  array(
                                1   =>  '*/*',     // 拥有全部的权限
                                2   =>  array('index/*','email/*','doc/*','knowledge/*'),
                                3   =>  array('index/*','email/*','knowledge/*','doc/add'),
                            ),
);