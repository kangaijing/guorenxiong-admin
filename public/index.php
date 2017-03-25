<?php
// 显示错误，调试使用
ini_set('display_errors', 'On');
// 报所有错误
error_reporting(E_ALL | E_STRICT);
// 报除 notice 外的错误
// error_reporting(E_ALL & ~E_NOTICE);

// 把 session 存入 redis，正式项目应该在 php.ini 中设置
// ini_set('session.save_handler', 'redis');
// ini_set('session.save_path', 'tcp://127.0.0.1:6379?auth=10010');

// 定义中国时区
date_default_timezone_set('PRC');

// 输入安全设置
if(ini_get('magic_quotes_gpc')){
	function stripslashesRecursive(array $array) {
		foreach($array as $k => $v){
			if(is_string($v)){
				$array[$k] = stripslashes($v);
			}else if(is_array($v)){
				$array[$k] = stripslashesRecursive($v);
			}
		}
		return $array;
	}
	$_GET = stripslashesRecursive($_GET);
	$_POST = stripslashesRecursive($_POST);
}

// 定义基目录
define('BASE_PATH', realpath(dirname(__FILE__) . '/../') . '/');
// 定义网站根目录
define('SITE_PATH', realpath(dirname(__FILE__)));
// 定义项目目录
define('APP_PATH', BASE_PATH . 'application/');
// 定义视图目录
define('VIEW_PATH', APP_PATH . 'views/');
// 定义缓存目录
define('RUNTIME_PATH', BASE_PATH . 'runtime/');

// 加载配置文件
$Yaf  = new Yaf_Application(BASE_PATH . 'conf/application.ini');

// 执行
$Yaf->bootstrap()->run();
