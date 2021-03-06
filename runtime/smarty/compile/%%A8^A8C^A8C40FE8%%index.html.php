<?php /* Smarty version 2.6.30, created on 2017-03-16 10:01:11
         compiled from menu/index.html */ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<!-- 头部公共文件 -->
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/tohead.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
	<link rel="stylesheet" href="/js/treeTable/treeTable.css" />
	<title>后台菜单列表</title>
	
	<style>
		.treeTable tr td .expander { margin-left: 0px; }
	</style>
</head>
<body>
<div class="container-fluid">
	<ul class="nav nav-tabs top15">
		<li class="active"><a href="/menu/index">后台菜单列表</a></li>
		<li><a href="/menu/add">添加菜单</a></li>
	</ul>
	<table class="table table-bordered table-hover table-list treeTable top15" id="menus-table">
		<thead>
			<tr style="background-color: #EEE;">
				<th width="5%"></th>
				<th>ID</th>
				<th>菜单名称</th>
				<th>url 路径</th>
				<th>上级菜单</th>
				<th>层级关系</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php $_from = $this->_tpl_vars['lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
				<tr id="node-<?php echo $this->_tpl_vars['val']['id']; ?>
" class="<?php echo $this->_tpl_vars['val']['pnode']; ?>
">
					<td></td>
					<td><?php echo $this->_tpl_vars['val']['id']; ?>
</td>
					<td><?php echo $this->_tpl_vars['val']['name']; ?>
</td>
					<td><?php echo $this->_tpl_vars['val']['url']; ?>
</td>
					<td><?php echo $this->_tpl_vars['val']['pid']; ?>
</td>
					<td><?php echo $this->_tpl_vars['val']['path']; ?>
</td>
					<td>
						<a url="/menu/delete" mid="<?php echo $this->_tpl_vars['val']['id']; ?>
" class="btn btn-danger btn-xs">删除</a>
						<a href="/menu/edit?id=<?php echo $this->_tpl_vars['val']['id']; ?>
" class="btn btn-warning btn-xs left10">编辑</a>
					</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
		</tbody>
		<tfoot>
			<tr style="background-color: #EEE;">
				<th width="5%"></th>
				<th>ID</th>
				<th>菜单名称</th>
				<th>url 路径</th>
				<th>上级菜单</th>
				<th>层级关系</th>
				<th>操作</th>
			</tr>
		</tfoot>
	</table>
</div>

<!-- 底部公共文件 -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/footer.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- 本页独立 js 在此处下方 -->
<script src="/js/treeTable/treeTable.js"></script>
<script>
$(document).ready(function(){
	// 树形菜单伸缩
	$("#menus-table").treeTable({
		indent : 20
	});
});
</script>
</body>
</html>