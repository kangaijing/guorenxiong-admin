<?php /* Smarty version 2.6.30, created on 2017-03-16 10:12:04
         compiled from hospital/index.html */ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<!-- 头部公共文件 -->
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/tohead.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
	<title>中医馆列表</title>
	
	<style>
		
	</style>
</head>
<body>
<div class="container-fluid">
	<ul class="nav nav-tabs top15">
		<li class="active"><a href="/hospital/index" class="index-url">中医馆列表</a></li>
		<li><a href="/hospital/add">添加中医馆</a></li>
	</ul>
	<table class="table table-bordered table-hover top15">
		<tr style="background-color: #EEE;">
			<th>ID</th>
			<th style="width: 180px;">中医馆名称</th>
			<th>所在地区</th>
			<th>详细地址</th>
			<th style="width: 150px;">经纬度</th>
			<th style="width: 50px;">类型</th>
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
				<?php echo $this->_tpl_vars['val']['name']; ?>
<br />
				<a class="btn btn-info btn-xs has-office" hospital_id="<?php echo $this->_tpl_vars['val']['id']; ?>
">科室</a>
				<a class="btn btn-success btn-xs has-service" hospital_id="<?php echo $this->_tpl_vars['val']['id']; ?>
">项目</a>
				<a class="btn btn-info btn-xs has-doctor" hospital_id="<?php echo $this->_tpl_vars['val']['id']; ?>
">医师</a>
				<a class="btn btn-success btn-xs has-registin" hospital_id="<?php echo $this->_tpl_vars['val']['id']; ?>
">挂号</a>
			</td>
			<td>
				<?php echo $this->_tpl_vars['val']['province']; ?>
 
				<?php echo $this->_tpl_vars['val']['city']; ?>
 
				<?php echo $this->_tpl_vars['val']['area']; ?>

			</td>
			<td><?php echo $this->_tpl_vars['val']['address']; ?>
</td>
			<td>
				经度：<?php echo $this->_tpl_vars['val']['lotitu']; ?>
<br />
				纬度：<?php echo $this->_tpl_vars['val']['latitu']; ?>

			</td>
			<td><?php echo $this->_tpl_vars['val']['type']; ?>
</td>
			<td>
				<?php if ($this->_tpl_vars['val']['status']): ?>
					<a class="btn btn-success btn-xs btn-status" hospital_id="<?php echo $this->_tpl_vars['val']['id']; ?>
">上线</a>
				<?php else: ?>
					<a class="btn btn-default btn-xs btn-status" hospital_id="<?php echo $this->_tpl_vars['val']['id']; ?>
">下线</a>
				<?php endif; ?>
			</td>
			<td>
				<a href="/hospital/edit?id=<?php echo $this->_tpl_vars['val']['id']; ?>
" class="btn btn-primary btn-xs">编辑</a>
			</td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>
		<tr style="background-color: #EEE;">
			<th>ID</th>
			<th>中医馆名称</th>
			<th>所在地区</th>
			<th>详细地址</th>
			<th>经纬度</th>
			<th>类型</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
	</table>
	<div class="page-info">
		<div id="page_info"></div>
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
	
	// 编辑状态
	$('.btn-status').on('click', function(){
		var url = '/hospital/editstatus';
		var hospital_id = $(this).attr('hospital_id');
		
		layer.confirm('您确认要修改该中医馆的状态吗？', function(){
			// 定义 loading 层
			var loading_index = layer.load(0, {shade: [0.1,'#FFF']});
			$.post(url, {hospital_id:hospital_id}, function(data){
				layer.close(loading_index); // 关闭 loading 层
				if(data.status == 1){
					layer.msg(data.info, {icon:1, time:1000}, function(){
						window.location.href = window.location.href;
					});
				}else{
					layer.msg(data.info, {icon:5, time:1000});
				}
			});
		});
	});
});
</script>
</body>
</html>