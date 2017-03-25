<?php /* Smarty version 2.6.30, created on 2017-03-16 10:00:40
         compiled from office/index.html */ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<!-- 头部公共文件 -->
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/tohead.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
	<title>科室基础数据列表</title>
	
	<style>
		
	</style>
</head>
<body>
<div class="container-fluid">
	<ul class="nav nav-tabs top15">
		<li class="active"><a href="/office/index" class="index-url">科室基础数据列表</a></li>
		<li><a href="/office/add">添加科室基础数据</a></li>
	</ul>
	<table class="table table-bordered table-hover top15">
		<tr style="background-color: #EEE;">
			<th>id</th>
			<th>科室名称</th>
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
			<td>
				<a href="/office/edit?id=<?php echo $this->_tpl_vars['val']['id']; ?>
" class="btn btn-primary btn-xs left10">编辑</a>
			</td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>
		<tr style="background-color: #EEE;">
			<th>id</th>
			<th>科室名称</th>
			<th>操作</th>
		</tr>
	</table>
	<div class="page-info top50">
		<div id="page_info">dddddddddd</div>
		<input type="hidden" id="allpages" value="<?php echo $this->_tpl_vars['allpages']; ?>
" />
		<input type="hidden" id="nowpage" value="<?php echo $this->_tpl_vars['nowpage']; ?>
" />
	</div>
</div>

<!-- 底部公共文件 -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/footer.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- 本页独立 js 在此处下方 -->
<script src="/js/laypage/laypage.js"></script>
<script>
$(function(){
	laypage({
		cont: 'page_info',
		pages: $('#allpages').val(),
		curr: function(){
				var page = $('#nowpage').val();
				return page ? page : 1;
			}(),
		jump: function(e, first){
			if(!first){
				location.href = '?page='+e.curr;
			}
		}
	});
});
</script>
</body>
</html>