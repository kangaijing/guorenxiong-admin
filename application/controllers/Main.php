<?php
/*
** 首页信息控制器
*/

class MainController extends AdminbaseController {
	protected $_db;
	// 自动优先加载
	public function init() {
		parent::init();
		
	}
	
	// 页面
	public function indexAction() {
		
		$this -> getView() -> display('main/index.html');
	}
	
}
