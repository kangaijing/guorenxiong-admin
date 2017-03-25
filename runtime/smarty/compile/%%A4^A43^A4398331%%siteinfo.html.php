<?php /* Smarty version 2.6.30, created on 2017-03-16 10:00:35
         compiled from setting/siteinfo.html */ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<!-- 头部公共文件 -->
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/tohead.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
	<title>网站信息</title>
	
	<style>
		
	</style>
</head>
<body>
<div class="container-fluid">
	<ul class="nav nav-tabs top15">
		<li class="active"><a href="/setting/siteinfo" class="index-url">网站信息</a></li>
	</ul>
	<form class="form-horizontal top20" name="dataForm" action="/setting/siteinfosave">
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 网站名称</label>
			<div class="col-sm-10">
				<input type="text" name="sitename" value="<?php echo $this->_tpl_vars['lists']['sitename']; ?>
" class="form-control width500" maxlength="50" placeholder="请输入网站名称" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 网站域名</label>
			<div class="col-sm-10">
				<input type="text" name="sitehost" value="<?php echo $this->_tpl_vars['lists']['sitehost']; ?>
" class="form-control width500" maxlength="50" placeholder="请输入网站域名" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> SEO 关键字</label>
			<div class="col-sm-10">
				<textarea name="seokey" class="form-control" maxlength="60" style="width: 500px; height: 55px; resize: none;" placeholder="请输入 SEO 关键字"><?php echo $this->_tpl_vars['lists']['seokey']; ?>
</textarea>
				<span class="help-block">请使用英文逗号分隔</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> SEO 描述</label>
			<div class="col-sm-10">
				<textarea name="seodesc" class="form-control" maxlength="120" style="width: 500px; height: 95px; resize: none;" placeholder="请输入 SEO 描述"><?php echo $this->_tpl_vars['lists']['seodesc']; ?>
</textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 版权信息</label>
			<div class="col-sm-10">
				<input type="text" name="copyright" value="<?php echo $this->_tpl_vars['lists']['copyright']; ?>
" class="form-control width500" maxlength="50" placeholder="请输入版权信息" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 备案号</label>
			<div class="col-sm-10">
				<input type="text" name="siteicp" value="<?php echo $this->_tpl_vars['lists']['siteicp']; ?>
" class="form-control width500" maxlength="50" placeholder="请输入备案号" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 公网安备案号</label>
			<div class="col-sm-10">
				<input type="text" name="sitecyber" value="<?php echo $this->_tpl_vars['lists']['sitecyber']; ?>
" class="form-control width500" maxlength="50" placeholder="请输入备案号" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 网站开关</label>
			<div class="col-sm-10">
				<?php if ($this->_tpl_vars['lists']['sitestatus'] == 1): ?>
					<label class="radio-inline">
						<input type="radio" name="sitestatus" value="0" /> 关闭
					</label>
					<label class="radio-inline">
						<input type="radio" name="sitestatus" value="1" checked="checked" /> 开启
					</label>
				<?php else: ?>
					<label class="radio-inline">
						<input type="radio" name="sitestatus" value="0" checked="checked" /> 关闭
					</label>
					<label class="radio-inline">
						<input type="radio" name="sitestatus" value="1" /> 开启
					</label>
				<?php endif; ?>
			</div>
		</div>
		<div class="form-group top30">
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