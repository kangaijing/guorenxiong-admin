<?php
/*
** 管理员独立控制器
*/

class MyinfoController extends AdminbaseController {
	protected $_db;
	
	// 自动优先加载
	public function init() {
		parent::init();
		
		// 初始化数据表
		$this -> _db = new medoo();
	}
	
	// 管理员修改密码
	public function repasswdAction() {
		$inputs = I('post.');
		$oldPasswd 		= $inputs['oldpasswd'];
		$newPasswd 		= $inputs['newpasswd'];
		$reNewPasswd 	= $inputs['renewpasswd'];
		
		// 判断
		if(!$oldPasswd){
			$this -> ajaxReturn(array('status' => 0, 'info' => '请输入原密码', 'refresh' => 0));
		}
		if(!$newPasswd){
			$this -> ajaxReturn(array('status' => 0, 'info' => '请输入新密码', 'refresh' => 0));
		}
		if(!$reNewPasswd){
			$this -> ajaxReturn(array('status' => 0, 'info' => '请再次输入新密码', 'refresh' => 0));
		}
		if(strlen($newPasswd) < 6){
			$this -> ajaxReturn(array('status' => 0, 'info' => '新密码长度不能小于 6 位', 'refresh' => 0));
		}
		if($newPasswd != $reNewPasswd){
			$this -> ajaxReturn(array('status' => 0, 'info' => '两次输入的新密码不一致', 'refresh' => 0));
		}
		
		$uid = session('uid');
		
		// 加密原密码
		$passwdOldEnc = manager_password($oldPasswd);
		// 加密新密码
		$passwdNewEnc = manager_password($reNewPasswd);
		
		$field = array('id', 'passwd');
		$where = array('id[=]' => $uid, 'LIMIT' => 1);
		$myinfo = $this -> _db -> select('mg_users', $field, $where); // 二维数组
		
		// 用户信息不存在
		if(!$myinfo){
			session(null); // 清空 session
			$this -> ajaxReturn(array('status' => 0, 'info' => '用户信息不存在', 'refresh' => 1, 'url' => '/'));
		}
		
		// 判断原密码
		if($myinfo[0]['passwd'] != $passwdOldEnc){
			$this -> ajaxReturn(array('status' => 0, 'info' => '原密码错误', 'refresh' => 0));
		}
		
		// 判断原密码和新密码
		if($myinfo[0]['passwd'] == $passwdNewEnc){
			$this -> ajaxReturn(array('status' => 0, 'info' => '新密码和原密码不能相同', 'refresh' => 0));
		}
		
		// 修改密码
		$data = array('passwd' => manager_password($reNewPasswd));
		$result = $this -> _db -> update('mg_users', $data, array('id'=>$uid));
		
		$info = array('status' => 0, 'info' => '修改密码失败', 'refresh' => 0);
		if($result){
			// 记录日志
			log_record(session('uid'), '修改密码', array());
			
			session(null); // 清空 session
			$info = array('status' => 1, 'info' => '修改密码成功，请重新登陆', 'url' => '/');
		}
		$this -> ajaxReturn($info);
	}
	
}
