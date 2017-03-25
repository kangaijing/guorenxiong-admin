$(document).ready(function(){
	// 刷新验证码
	function refreshVerify(){  // 验证码刷新函数
		var url = $('#verifyurl').attr('url');
		var ranTime = Math.random();
		var src = url.replace('rantime', ranTime);
		$('#logverify').attr('src',src);
		$('input[name="verify"]').val('');  // 清空验证码输入框
	}

	// 单击刷新验证码
	$('#logverify').on('click',function(){
		refreshVerify();
	});

	// 处理登陆的函数
	function doLogin(){
		var urls = $('form[name="loginForm"]').attr('action');
		var formData = $('form[name="loginForm"]').serialize();
		// 定义 loading 层
		var loading_index = layer.load(0, {shade: [0.1,'#FFF']});
		$.post(urls, formData, function(data){
			layer.close(loading_index); // 关闭 loading 层
			if(data.status == 1){
				// 清空表单内容
				$('form[name="loginForm"] input').val('');
				layer.msg(data.info, {icon:1,time:1500}, function(){
					window.location.href = data.url;
				});
			}else{
				layer.msg(data.info, {icon:5, time:1500}, function(){
					if(data.refresh == 1){
						// 刷新验证码
						refreshVerify();
					}
				});
			}
		});
	}

	// 登陆
	$('.dologin').on('click',function(){
		doLogin();
	});

	// 监听输入框的回车事件
	$('input').keydown(function(event){
		if(event.keyCode == 13){
			doLogin();
		}
	});
});
