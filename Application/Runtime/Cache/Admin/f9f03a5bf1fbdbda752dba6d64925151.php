<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/Public/Admin/css/base.css" />
	<link rel="stylesheet" href="/Public/Admin/css/info-mgt.css" />
	<link rel="stylesheet" href="/Public/Admin/css/WdatePicker.css" />
	<title>移动办公自动化系统</title>
	<style type='text/css'>
		table tr .id{ width:63px; text-align: center;}
		table tr .name{ width:118px; padding-left:17px;}
		table tr .nickname{ width:63px; padding-left:17px;}
		table tr .dept_id{ width:63px; padding-left:13px;}
		table tr .sex{ width:63px; padding-left:13px;}
		table tr .birthday{ width:80px; padding-left:13px;}
		table tr .tel{ width:113px; padding-left:13px;}
		table tr .email{ width:160px; padding-left:13px;}
		table tr .addtime{ width:160px; padding-left:13px;}
		table tr .operate{ padding-left:13px;}
	</style>
</head>

<body>
	<div class="title"><h2>信息管理</h2></div>
	<div class="table-operate ue-clear">
		<a href="javascript:;" class="add">添加</a>
		<a href="javascript:;" class="del">删除</a>
		<a href="javascript:;" class="edit">编辑</a>
		<a href="/index.php/Admin/User/charts" class="count">统计</a>
		<a href="javascript:;" class="check">审核</a>
	</div>
	<div class="table-box">
		<table>
			<thead>
				<tr>
					<th class="id">序号</th>
					<th class="name">姓名</th>
					<th class="name">用户名</th>
					<th class="nickname">昵称</th>
					<th class="dept_id">所属部门</th>
					<th class="sex">性别</th>
					<th class="birthday">生日</th>
					<th class="tel">电话</th>
					<th class="email">邮箱</th>
					<th class="addtime">添加时间</th>
					<th class="operate">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($data)): foreach($data as $key=>$fo): ?><tr>
						<td class="id"><?php echo ($fo["id"]); ?></td>
						<td class="name"><?php echo ($fo["truename"]); ?></td>
						<td class="name"><?php echo ($fo["username"]); ?></td>
						<td class="nickname"><?php echo ($fo["nickname"]); ?></td>
						<td class="dept_id"><?php echo ($vol["dept_id"]); ?></td>
						<td class="sex"><?php echo ($fo["sex"]); ?></td>
						<td class="birthday"><?php echo ($fo["birthday"]); ?></td>
						<td class="tel"><?php echo ($fo["tel"]); ?></td>
						<td class="email"><?php echo ($fo["email"]); ?></td>
						<td class="addtime"><?php echo (date('Y-m-d H:i:s',$fo["addtime"])); ?></td>
						<td class="operate">
							<input type="checkbox" class="deptid" value="<?php echo ($fo["id"]); ?>"/>
							<a href="/index.php/Admin/User/edit/id/<?php echo ($fo["id"]); ?>">编辑</a>
						</td>
					</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
	</div>
	<div class="pagination ue-clear">
		<div class="pagin-list">
			<?php echo ($show); ?>
		</div>
		<div class="pxofy">显示第 <?php echo ($first); ?> 条到 <?php echo ($last); ?> 条记录，总共 <?php echo ($count); ?> 条记录</div>
	</div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript">
	$(".select-title").on("click",function(){
		$(".select-list").hide();
		$(this).siblings($(".select-list")).show();
		return false;
	})
	$(".select-list").on("click","li",function(){
		var txt = $(this).text();
		$(this).parent($(".select-list")).siblings($(".select-title")).find("span").text(txt);
	})

// $('.pagination').pagination(100,{
// 	callback: function(page){
// 		alert(page);	
// 	},
// 	display_msg: true,
// 	setPageNo: true
// });

$("tbody").find("tr:odd").css("backgroundColor","#eff6fa");

showRemind('input[type=text], textarea','placeholder');

// jQuery代码
$(function(){
    // 给删除按钮绑定点击事件
    $('.del').on('click',function(){
        // 事件处理程序
        var idObj = $(':checkbox:checked');     // 获取全部已经选中的checkbox
        var id = '';    //接收处理后的部门id值，组成id1,id2,id3....这种形式
        // 循环遍历idObj对象，获取其中的每一个值
        for (var i = 0; i < idObj.length; i++) {
        	id += idObj[i].value + ',';
        }
        // 去掉最后的逗号
        id = id.substring(0,id.length - 1);
        // 带着参数跳转到del方法
        window.location.href = '/index.php/Admin/User/del/id/' + id;
    });
});
</script>
</html>