<?php /* Smarty version 2.6.30, created on 2017-03-16 10:21:27
         compiled from rbac/authorize.html */ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<!-- 头部公共文件 -->
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'public/tohead.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
	<title>权限设置</title>
	
	<style>
		#rbacmenubox .panel { margin-bottom: 0px; }
		#rbacmenubox .panel .panel-heading { padding: 1px 10px; }
		#rbacmenubox .panel .panel-body { padding: 0px; }
		#rbacmenubox .panel .checkbox { margin-top: 5px; margin-bottom: 3px; }
		#rbacmenubox .semenus { color: red; }
		#rbacmenubox ul li { float: left; width: 200px; }
		
	</style>
</head>
<body>
<div class="container-fluid">
	<div id="rbacmenubox" class="top10" index-url="/rbac/index">
		<?php echo $this->_tpl_vars['rbacmenu']; ?>

		<div class="cleardiv"></div>
		<div class="top15" style="text-align: center;">
			<a class="btn btn-primary btn-checkall">全选</a>
			<a class="btn btn-primary btn-checknot left10">全不选</a>
			<a class="btn btn-primary btn-saverole left10" url="/rbac/saveauthorize" rid="<?php echo $this->_tpl_vars['role_id']; ?>
">保存</a>
		</div>
	</div>
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
	//获取窗口索引
	var win_index = parent.layer.getFrameIndex(window.name);
	
	// 单小菜单 全选 / 全不选
	$('#rbacmenubox').on('click', '.firmenuall', function(){
		var val = $(this).val();
		var status = $(this).prop('checked');
		if(status){
			$('#rbacmenubox .semenu' + val).prop('checked', true);
		}else{
			$('#rbacmenubox .semenu' + val).prop('checked', false);
		}
	});
	// 总体 全选
	$('#rbacmenubox').on('click', '.btn-checkall', function(){
		$('#rbacmenubox .rolecheck').prop('checked', true);
	});
	// 总体 全不选
	$('#rbacmenubox').on('click', '.btn-checknot', function(){
		$('#rbacmenubox .rolecheck').prop('checked', false);
	});
	
	// 保存权限
	$('#rbacmenubox').on('click', '.btn-saverole', function(){
		var url = $(this).attr('url');
		var rid = $(this).attr('rid');
		var inputs = $('#rbacmenubox input[name="ids[]"]');
		var ids = '';
		$.each(inputs, function(idv, item){
			if(item.checked == true){
				ids += item.value + ',';
			}
		});
		
		var load_index = layer.load(0, {shade: false}); // loading 层
		$.post(url, {id:rid, ids:ids}, function(data){
			if(data.status == 1){
				layer.msg(data.info, {icon:1, time:1000}, function(){
					parent.layer.close(win_index);
					layer.close(load_index); // 关闭 loading 层
					window.location.href = $('#rbacmenubox').attr('index-url');
				});
			}else{
				layer.msg(data.info, {icon:5, time:1000}, function(){
					layer.close(load_index); // 关闭 loading 层
				});
			}
		});
	});
});
</script>
</body>
</html>