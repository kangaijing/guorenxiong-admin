<?php /* Smarty version 2.6.30, created on 2017-03-16 10:21:22
         compiled from users/index.html */ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<!-- 头部公共文件 -->
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/tohead.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
	<title>管理员列表</title>
	
	<style>
		
	</style>
</head>
<body>
<div class="container-fluid">
	<ul class="nav nav-tabs top15">
		<li class="active"><a href="/users/index">管理员列表</a></li>
		<li><a href="/users/add">添加管理员</a></li>
	</ul>
	<table id="managers" class="table table-bordered table-hover top15">
		<tr style="background-color: #EEE;">
			<th>id</th>
			<th>用户名</th>
			<th>最后登陆 IP</th>
			<th>最后登陆时间</th>
			<th>登陆次数</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
		<?php $_from = $this->_tpl_vars['lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
		<tr>
			<td><?php echo $this->_tpl_vars['val']['id']; ?>
</td>
			<td>
				<?php echo $this->_tpl_vars['val']['username']; ?>

			</td>
			<td><?php echo $this->_tpl_vars['val']['login_ip']; ?>
</td>
			<td><?php echo $this->_tpl_vars['val']['time_login']; ?>
</td>
			<td><?php echo $this->_tpl_vars['val']['login_count']; ?>
</td>
			<td>
				<?php if ($this->_tpl_vars['val']['status']): ?>
					<div class="btn btn-success btn-xs <?php if ($this->_tpl_vars['val']['id'] == 1): ?><?php else: ?>btn-editstatus<?php endif; ?>" username="<?php echo $this->_tpl_vars['val']['username']; ?>
"  url="/users/editstatus" uid="<?php echo $this->_tpl_vars['val']['id']; ?>
" acts="禁用">已启用</div>
				<?php else: ?>
					<div class="btn btn-default btn-xs <?php if ($this->_tpl_vars['val']['id'] == 1): ?><?php else: ?>btn-editstatus<?php endif; ?>" username="<?php echo $this->_tpl_vars['val']['username']; ?>
"  url="/users/editstatus" uid="<?php echo $this->_tpl_vars['val']['id']; ?>
" acts="启用">已禁用</div>
				<?php endif; ?>
			</td>
			<td>
				<?php if ($this->_tpl_vars['val']['id'] == 1): ?>
					<div class="btn btn-default btn-xs">编辑</div>
				<?php else: ?>
					<a class="btn btn-danger btn-xs btn-repasswd" username="<?php echo $this->_tpl_vars['val']['username']; ?>
"  url="/users/repasswd" uid="<?php echo $this->_tpl_vars['val']['id']; ?>
">重置密码</a>
					<a href="/users/edit?id=<?php echo $this->_tpl_vars['val']['id']; ?>
" class="btn btn-warning btn-xs left10">编辑</a>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>
		<tr style="background-color: #EEE;">
			<th>id</th>
			<th>用户名</th>
			<th>最后登陆 IP</th>
			<th>最后登陆时间</th>
			<th>登陆次数</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
	</table>
</div>

<!-- 底部公共文件 -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/footer.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- 本页独立 js 在此处下方 -->
<script>
$(document).ready(function(){
	// 重置密码
	$('#managers .btn-repasswd').on('click', function(){
		var url = $(this).attr('url');
		var uid = $(this).attr('uid');
		var username = $(this).attr('username');
		var pass = '';
		username = '<a style="color:red;">' + username + '</a>';
		
		layer.confirm('您确认要重置用户 ' + username + ' 的密码吗？', function(){
			var pass_index = layer.prompt({ // 定义弹窗层
				title: '请输入新密码',
				formType: 1 //prompt风格，支持0-2
			}, function(pass){
				// 定义 loading 层
				var loading_index = layer.load(0, {shade: [0.1,'#FFF']});
				$.post(url, {id:uid,passwd:pass}, function(data){
					layer.close(loading_index); // 关闭 loading 层
					if(data.status == 1){
						layer.msg(data.info, {icon:1, time:1000}, function(){
							layer.close(pass_index); // 关闭弹窗层
						});
					}else{
						layer.msg(data.info, {icon:5, time:1000})
					}
				});
			});
		});
	});
	// 编辑状态
	$('#managers .btn-editstatus').on('click', function(){
		var url = $(this).attr('url');
		var uid = $(this).attr('uid');
		var username = $(this).attr('username');
		var acts = $(this).attr('acts');
		username = '<a style="color:red;">' + username + '</a>';
		
		layer.confirm('您确认要 ' + acts + ' 用户 ' + username + ' 吗？', function(){
			// 定义 loading 层
			var loading_index = layer.load(0, {shade: [0.1,'#FFF']});
			$.post(url, {id:uid}, function(data){
				layer.close(loading_index); // 关闭 loading 层
				if(data.status == 1){
					layer.msg(data.info, {icon:1, time:1000}, function(){
						window.location.href = window.location.href;
					});
				}else{
					layer.msg(data.info, {icon:5, time:1000})
				}
			});
		});
	});
	
});
</script>
</body>
</html>