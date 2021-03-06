<?php /* Smarty version 2.6.30, created on 2017-03-16 09:57:19
         compiled from public/login.html */ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>登陆</title>
	
	<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="/favicon.ico" rel="shortcut icon" />
	
	<!--[if lt IE 9]>
		<script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<style>
		.container { margin-top: 150px; width: 400px; }
		.title-font { text-align: center; font-size: 24px; }
		.form-font { text-align: center; }
		.input-groups { width: 300px; margin: 0px auto; }
		input.form-control { font-size: 19px; }
		img.verify-img {
			width: 300px;
			height: 50px;
			cursor: pointer;
			border: 1px solid #CCC;
			border-radius: 4px;
		}
	</style>
	<script>
		// 判断是否在 iframe 中，如果是，则刷新父页面
		if(self.frameElement && self.frameElement.tagName == "IFRAME"){
			parent.location.reload();
		}
	</script>
</head>
<body style="background-image:url(/images/login-bg3.jpg);background-position: 50% 30%; background-repeat:no-repeat;">
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title title-font">后 台 管 理 中 心</div>
		</div>
		<div class="panel-body">
			<form class="form-horizontal form-font" name="loginForm" method="post" action="/public/dologin">
				<div class="form-group">
					<div class="input-group input-groups">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-user"></i>
						</span>
						<input type="text" class="form-control" name="username" placeholder="用户名" />
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-groups">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-lock"></i>
						</span>
						<input type="password" class="form-control" name="password" placeholder="密码" />
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-groups">
						<img id="logverify" class="verify-img" src="/public/verify" />
					</div>
					<div id="verifyurl" url="/public/verify?time=rantime" style="display: none;"></div>
				</div>
				<div class="form-group">
					<input type="text" class="form-control input-groups" name="verify" placeholder="验证码" />
				</div>
				<div class="form-group" style="margin-bottom: 0px;">
					<div class="btn btn-primary dologin" style="width: 300px;">登 陆</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="/js/jquery.min.js"></script>
<script src="/js/dologin.js"></script>
<script src="/js/layer/layer.js"></script>
</body>
</html>