<?php
/*
** 后台首页控制器
*/

class IndexController extends AdminbaseController {
	// 自动优先加载
	public function init() {
		parent::init();
	}
	
	// 后台首页界面
	public function indexAction() {
		header('Content-Type:text/html;charset=utf-8');
		
		$userInfo = session();
		
		$menuInfo = parent::menu_json();
		$menulists = getsubmenu($menuInfo);
		
		$showData = array(
				// 输出左侧后台菜单
				'menulists' => $menulists,
				// 获取当前登陆管理员
				'username' 	=> $userInfo['nickname'] ? $userInfo['nickname'] : $userInfo['username'],
				// 输出系统时间
				'systime' => time(),
			);
		
		$this -> getView() -> assign($showData);
		$this -> getView() -> display('index/index.html');
	}
	
}
