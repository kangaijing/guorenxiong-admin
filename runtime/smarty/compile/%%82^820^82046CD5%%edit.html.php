<?php /* Smarty version 2.6.30, created on 2017-03-16 10:42:29
         compiled from menu/edit.html */ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<!-- 头部公共文件 -->
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/tohead.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
	<title>编辑菜单</title>
	
	<style>
		
	</style>
</head>
<body>
<div class="container-fluid">
	<ul class="nav nav-tabs top15">
		<li><a href="/menu/index" class="index-url">后台菜单列表</a></li>
		<li><a href="/menu/add">添加菜单</a></li>
		<li class="active"><a>编辑菜单</a></li>
	</ul>
	<form class="form-horizontal top20" name="dataForm" action="/menu/editsave">
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 上级菜单</label>
			<div class="col-sm-10">
				<input type="text" class="form-control width400" value="<?php echo $this->_tpl_vars['lists']['pname']; ?>
" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 菜单名称</label>
			<div class="col-sm-10">
				<input type="text" name="name" value="<?php echo $this->_tpl_vars['lists']['name']; ?>
" class="form-control width400" placeholder="请输入菜单名称" />
				<span class="help-block">菜单名称不能重复</span>
			</div>
		</div>
		<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['lists']['id']; ?>
" />
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 控制器名称</label>
			<div class="col-sm-10">
				<input type="text" name="model" value="<?php echo $this->_tpl_vars['lists']['model']; ?>
" class="form-control width400" placeholder="请输入控制器名称" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 方法名称</label>
			<div class="col-sm-10">
				<input type="text" name="action" value="<?php echo $this->_tpl_vars['lists']['action']; ?>
" class="form-control width400" placeholder="请输入方法名称" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">顶级菜单图标</label>
			<div class="col-sm-10">
				<input type="text" name="icon" value="<?php echo $this->_tpl_vars['lists']['icon']; ?>
" class="form-control width400" placeholder="请输入顶级菜单图标" />
				<span class="help-block">示例：<i class="fa fa-apple"></i> class="fa fa-apple" 只取 fa- 后面的字符。<a href="http://www.fontawesome.com.cn/faicons/" target="_blank">图标网址</a></span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 菜单状态</label>
			<div class="col-sm-10">
				<select class="form-control width400" name="status">
					<?php if ($this->_tpl_vars['lists']['status']): ?>
						<option value="0">隐藏</option>
						<option value="1" selected="selected">显示</option>
					<?php else: ?>
						<option value="0" selected="selected">隐藏</option>
						<option value="1">显示</option>
					<?php endif; ?>
				</select>
				<span class="help-block">要在左侧菜单栏中显示，请选择 显示</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 菜单类型</label>
			<div class="col-sm-10">
				<select class="form-control width400" name="type">
					<?php if ($this->_tpl_vars['lists']['type']): ?>
						<option value="0">只作为菜单</option>
						<option value="1" selected="selected">权限认证 + 菜单</option>
					<?php else: ?>
						<option value="0" selected="selected">只作为菜单</option>
						<option value="1">权限认证 + 菜单</option>
					<?php endif; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<a class="btn btn-primary btn-save">保 存</a>
				<a class="btn btn-default left20 btn-cancel">返 回</a>
			</div>
		</div>
	</form>
</div>

<!-- 底部公共文件 -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/footer.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- 本页独立 js 在此处下方 -->
</body>
</html>