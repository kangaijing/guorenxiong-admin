<?php /* Smarty version 2.6.30, created on 2017-03-16 13:51:41
         compiled from article/newsadd.html */ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<!-- 头部公共文件 -->
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/tohead.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
	<title>添加动态</title>
	
	<style>
		
	</style>
</head>
<body>
<div class="container-fluid">
	<ul class="nav nav-tabs top15">
		<li><a href="/article/news" class="index-url">医院动态列表</a></li>
		<li class="active"><a href="/article/newsadd">添加动态</a></li>
	</ul>
	<form class="form-horizontal top20" name="dataForm" action="/article/newssave">
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 标题</label>
			<div class="col-sm-10">
				<input type="text" name="name" class="form-control width400" placeholder="请输入标题" />
				<span class="help-block">标题最多100个汉字</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 副标题</label>
			<div class="col-sm-10">
				<input type="text" name="name" class="form-control width400" placeholder="请输入副标题" />
				<span class="help-block">副标题最多100个汉字</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 文章摘要</label>
			<div class="col-sm-10">
				<textarea class="form-control width400" rows="3" placeholder="请输入文章摘要"></textarea>
				<span class="help-block">文章摘要最多200个汉字</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 内容详情</label>
			<div class="col-sm-10">
				<script id="container" name="content" type="text/plain" style="width: 700px;height: 300px;"></script>
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
<!-- 编辑器配置文件 -->
<script type="text/javascript" src="/js/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/js/ueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
</script>
<!-- 底部公共文件 -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/footer.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- 本页独立 js 在此处下方 -->
</body>
</html>