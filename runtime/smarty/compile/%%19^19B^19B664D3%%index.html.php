<?php /* Smarty version 2.6.30, created on 2017-03-16 10:21:24
         compiled from rbac/index.html */ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<!-- 头部公共文件 -->
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/tohead.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
	<title>角色管理</title>
	
	<style>
		
	</style>
</head>
<body>
<div class="container-fluid">
	<ul class="nav nav-tabs top15">
		<li class="active"><a href="/rbac/index">角色列表</a></li>
		<li><a href="/rbac/add">添加角色</a></li>
	</ul>
	<table id="managers" class="table table-bordered table-hover top15">
		<tr style="background-color: #EEE;">
			<th>id</th>
			<th>角色名称</th>
			<th>备注</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
		<?php $_from = $this->_tpl_vars['lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
		<tr>
			<td><?php echo $this->_tpl_vars['val']['id']; ?>
</td>
			<td><?php echo $this->_tpl_vars['val']['name']; ?>
</td>
			<td><?php echo $this->_tpl_vars['val']['remark']; ?>
</td>
			<td>
				<?php if ($this->_tpl_vars['val']['status']): ?>
					<div class="btn btn-success btn-xs">已启用</div>
				<?php else: ?>
					<div class="btn btn-default btn-xs">未启用</div>
				<?php endif; ?>
			</td>
			<td>
				<?php if ($this->_tpl_vars['val']['id'] == 1): ?>
					<div class="btn btn-default btn-xs">编辑</div>
					<div class="btn btn-default btn-xs">权限设置</div>
				<?php else: ?>
					<a class="btn btn-danger btn-xs btn-delete" username="<?php echo $this->_tpl_vars['val']['username']; ?>
" url="/rbac/delete" rid="<?php echo $this->_tpl_vars['val']['id']; ?>
">删除</a>
					
					<a class="btn btn-warning btn-xs left10 btn-chkrole" url="/rbac/authorize?id=<?php echo $this->_tpl_vars['val']['id']; ?>
">权限设置</a>
					<a href="/rbac/edit?id=<?php echo $this->_tpl_vars['val']['id']; ?>
" class="btn btn-primary btn-xs left10">编辑</a>
					<a url="/rbac/edit?id=<?php echo $this->_tpl_vars['val']['id']; ?>
" class="btn btn-info btn-xs left10">组成员</a>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>
		<tr style="background-color: #EEE;">
			<th>id</th>
			<th>角色名称</th>
			<th>备注</th>
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
	// 弹窗 权限设置
	$('.btn-chkrole').on('click', function(){
		var url = $(this).attr('url');
		layer.open({
			type: 2,
			title: '权限设置',
			shadeClose: false,
			shade: 0.1,
			area: ['90%', '90%'],
			content: url
		});
	});
});
</script>
</body>
</html>