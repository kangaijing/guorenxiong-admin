<?php
/*
** 异常捕获控制器，上线要关闭
*/

class ErrorController extends AdminbaseController {
	
	// 自动优先加载
	public function init() { }
	
	public function errorAction($exception) {
		// 关闭模板输出
		Yaf_Dispatcher::getInstance()->disableView();
		
		// 写入系统日志
		Log::write($exception -> getMessage());
		
		// 捕获异常信息
		switch($exception->getCode()){
			case YAF_ERR_NOTFOUND_MODULE:
			case YAF_ERR_NOTFOUND_CONTROLLER:
			case YAF_ERR_NOTFOUND_ACTION:
			case YAF_ERR_NOTFOUND_VIEW:
				echo 404, ':', $exception->getMessage();
				break;
				//header("HTTP/1.1 404 Not Found");
				//header("Status: 404 Not Found");
			default:
				$message = $exception->getMessage();
				echo 0, ':', $exception->getMessage();
				break;
				//header("HTTP/1.1 404 Not Found");
				//header("Status: 404 Not Found");
		}
		// 这里可以做些什么
		exit();
	}
	
}

