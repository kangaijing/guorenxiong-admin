<?php
/*
** 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
** 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
** 调用的次序, 和申明的次序相同
*/

class Bootstrap extends Yaf_Bootstrap_Abstract {
	
	// 启用 session
	public function _initSession() {
		Yaf_Session::getInstance()->start();
	}
	
	// 加载配置
	public function _initConfig() {
		$config = Yaf_Application::app()->getConfig();
		Yaf_Registry::set('config', $config);
	}
	
	// 关闭自动加载视图模板
	public function _initView() {
		//Yaf_Dispatcher::getInstance()->disableView();
		Yaf_Dispatcher::getInstance()->autoRender(false);
	}
	
	// 加载函数库
	public function _initCommonFunctions() {
		Yaf_Loader::import(APP_PATH . 'common/sysfunction.php');
		Yaf_Loader::import(APP_PATH . 'common/function.php');
		Yaf_Loader::import(APP_PATH . 'common/redisfunction.php');
	}
	
	// 初始化 Smarty 模板引擎
	public function _initSmarty(Yaf_Dispatcher $dispatcher) {
		$config = Yaf_Application::app() -> getConfig() -> get('smarty');
		$smarty = new Smarty_Adapter(null , $config);
		$dispatcher -> setView($smarty);
	}
	
	// 加载公共基类控制器，按顺序
	public function _initBaseController() {
		Yaf_Loader::import(APP_PATH . 'base/Base.php');
		Yaf_Loader::import(APP_PATH . 'base/Adminbase.php');
	}
	
	// 设置路由规则
	public function _initRoute(Yaf_Dispatcher $dispatcher) {
		$Router = $dispatcher->getRouter();
		$rewrite_route  = new Yaf_Route_Rewrite(
			'/product/list/:page',
			array(
				'controller' => 'product',
				'action'     => 'list',
			)
		);
		
		$regex_route  = new Yaf_Route_Rewrite(
			'/product/info/(\d+)',
			array(
				'controller' => 'product',
				'action'     => 'info',
			)
		);
		
		$Router -> addRoute('rewrite', $rewrite_route)
				-> addRoute('regex', $regex_route);
	}
	
}
