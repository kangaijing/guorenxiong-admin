$(document).ready(function(){
	
	// 提交数据
	$('form[name="dataForm"] .btn-save').on('click', function(){
		var url = $('form[name="dataForm"]').attr('action');
		var formData = $('form[name="dataForm"]').serialize();
		
		// 定义 loading 层
		var loading_index = layer.load(0, {shade: [0.1,'#FFF']});
		$.post(url, formData, function(data){
			layer.close(loading_index); // 关闭 loading 层
			if(data.status == 1){
				$('form[name="dataForm"] input').val('');
				layer.msg(data.info, {icon:1, time:1000}, function(){
					window.location.href = $('.index-url').attr('href');
				});
			}else{
				layer.msg(data.info, {icon:5, time:1000}, function(){
					if(data.refresh == 1){
						window.location.href = data.url;
					}
				});
			}
		});
	});
	
	// 返回
	$('form[name="dataForm"] .btn-cancel').on('click', function(){
		var url = $('.index-url').attr('href');
		window.location.href = url;
	});
	
});