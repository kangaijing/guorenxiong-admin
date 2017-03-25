<?php /* Smarty version 2.6.30, created on 2017-03-16 10:00:36
         compiled from setting/imageset.html */ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<!-- 头部公共文件 -->
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/tohead.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
	<link href="/js/webuploader/webuploader.css" rel="stylesheet" />
	<title>图片配置</title>
	
	<style>
		
	</style>
</head>
<body>
<div class="container-fluid">
	<ul class="nav nav-tabs top15">
		<li class="active"><a href="/setting/imageset" class="index-url">图片配置</a></li>
	</ul>
	<form class="form-horizontal top20" name="dataForm" action="/setting/siteinfosave">
		<div class="form-group">
			<label class="col-sm-2 control-label" style="font-size: 18px;">图片水印</label>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 水印开关</label>
			<div class="col-sm-10">
				<?php if ($this->_tpl_vars['lists']['wateruse'] == 1): ?>
					<label class="radio-inline">
						<input type="radio" name="wateruse" value="0" /> 关闭
					</label>
					<label class="radio-inline">
						<input type="radio" name="wateruse" value="1" checked="checked" /> 开启
					</label>
				<?php else: ?>
					<label class="radio-inline">
						<input type="radio" name="wateruse" value="0" checked="checked" /> 关闭
					</label>
					<label class="radio-inline">
						<input type="radio" name="wateruse" value="1" /> 开启
					</label>
				<?php endif; ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 水印图片</label>
			<div class="col-sm-10">
				<div id="filePicker" style="width: 120px; height: 50px;">
					<img src="/images/logo.png" style="width: 120px; height: 50px;" />
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 水印位置</label>
			<div class="col-sm-10">
				<label class="radio-inline">
					<input type="radio" name="waterseat" value="1" /> 左上角
				</label>
				<label class="radio-inline">
					<input type="radio" name="waterseat" value="2" /> 上居中
				</label>
				<label class="radio-inline">
					<input type="radio" name="waterseat" value="3" /> 右上角
				</label><br />
				<label class="radio-inline">
					<input type="radio" name="waterseat" value="4" /> 左居中
				</label>
				<label class="radio-inline">
					<input type="radio" name="waterseat" value="5" /> 正居中
				</label>
				<label class="radio-inline">
					<input type="radio" name="waterseat" value="6" /> 右居中
				</label><br />
				<label class="radio-inline">
					<input type="radio" name="waterseat" value="7" /> 左下角
				</label>
				<label class="radio-inline">
					<input type="radio" name="waterseat" value="8" /> 下居中
				</label>
				<label class="radio-inline">
					<input type="radio" name="waterseat" value="9" checked="checked" /> 右下角
				</label>
			</div>
		</div>
		<div class="form-group">
			<hr style="margin-top: 0px; margin-bottom: 0px; width: 85%; border-top: 1px dashed #AAA;" />
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="font-size: 18px;">生成缩略图</label>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="must-red">*</span> 缩略图开关</label>
			<div class="col-sm-10">
				<?php if ($this->_tpl_vars['lists']['thumbimg'] == 1): ?>
					<label class="radio-inline">
						<input type="radio" name="thumbimg" value="0" /> 关闭
					</label>
					<label class="radio-inline">
						<input type="radio" name="thumbimg" value="1" checked="checked" /> 开启
					</label>
				<?php else: ?>
					<label class="radio-inline">
						<input type="radio" name="thumbimg" value="0" checked="checked" /> 关闭
					</label>
					<label class="radio-inline">
						<input type="radio" name="thumbimg" value="1" /> 开启
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
<script src="/js/webuploader/webuploader.nolog.min.js"></script>
<script>
// 水印图片上传
jQuery(function() {
	var $ = jQuery, uploader;
	// 初始化Web Uploader
	uploader = WebUploader.create({
		// 自动上传
		auto: true,
		// swf文件路径
		swf: '/js/webuploader/Uploader.swf',
		// 文件接收服务端
		server: '/setting/imageup',
		// 选择文件的按钮。可选。
		// 内部根据当前运行是创建，可能是input元素，也可能是flash
		pick: '#filePicker',
		// 只允许选择文件，可选。
		accept: {
			title: 'Images',
			extensions: 'gif,jpg,jpeg,bmp,png',
			mimeTypes: 'image/*'
		}
	});
	
	// 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) { });
	
	// 文件上传过程中创建进度条实时显示
	uploader.on( 'uploadProgress', function( file, percentage ) { });
	
	// 文件上传成功，给item添加成功class, 用样式标记上传成功
	uploader.on( 'uploadSuccess', function(file, ret) {
		
	});
	
	// 文件上传失败，现实上传出错
	uploader.on( 'uploadError', function( file ) { });
	
	// 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) { });
});
</script>
</body>
</html>