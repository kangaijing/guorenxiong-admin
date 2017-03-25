<?php
/*
** 管理员控制器
*/

class UsersController extends AdminbaseController {
	protected $_db;
	// 自动优先加载
	public function init() {
		parent::init();
		
		$this -> _db = new medoo();
	}
	
	// 管理员列表页面
	public function indexAction() {
		
		$field = '*';
		$where = array();
		$lists = array();
		$lists = $this -> _db -> select('mg_users', $field, $where);
		// 替换
		foreach($lists as $key => &$val){
			$nickname = $val['nickname'] ? ' ( ' . $val['nickname'] . ' )' : '';
			$val['username'] = $val['name'] . $nickname;
			$val['login_ip'] = long2ip($val['login_ip']);
			unset($val['name']);
			unset($val['nickname']);
			$val['time_login'] = $val['time_login'] ? date('Y-m-d H:i:s', $val['time_login']) : 0;
		}
		
		$this -> getView() -> assign('lists', $lists);
		$this -> getView() -> display('users/index.html');
	}
	
	// 添加管理员页面
	public function addAction() {
		
		$this -> getView() -> assign('rolelists', $this->getRoleList()); // 角色组选择框
		$this -> getView() -> display('users/add.html');
	}
	
	// 保存添加管理员
	public function addsaveAction() {
		$inputs 	= I('post.');
		$name 		= $inputs['name'];
		$nickname 	= $inputs['nickname'];
		$passwd 	= $inputs['password'];
		$role_id 	= I('post.rid', 0, 'intval');
		
		// 判断
		if(!$name){
			$this -> ajaxReturn(array('status' => 0, 'info' => '请输入用户名'));
		}
		if(!$passwd){
			$this -> ajaxReturn(array('status' => 0, 'info' => '请输入密码'));
		}
		if(strlen($passwd) < 6){
			$this -> ajaxReturn(array('status' => 0, 'info' => '密码长度不能小于 6 位'));
		}
		if(!$role_id){
			$this -> ajaxReturn(array('status' => 0, 'info' => '请为该用户分配一个角色'));
		}
		
		// 保存用户信息
		$data['name'] 			= $name;
		$data['nickname'] 		= $nickname;
		$data['passwd'] 		= manager_password($passwd);
		$data['time_create'] 	= time();
		
		$result = $this -> _db -> insert('mg_users', $data);
		
		$info = array('status' => 0, 'info' => '操作失败');
		if($result){
			unset($data['passwd']);
			unset($data['time_create']);
			// 记录日志
			log_record(session('uid'), '添加管理员', $data);
			
			// 保存角色
			$roleHas = $this -> _db -> select('mg_roleuser', array('uid'), array('uid[=]'=>$result, 'LIMIT'=>1));
			if($roleHas){
				// 存在则删除
				$this -> _db -> delete('mg_roleuser', array('uid[=]'=>$result));
			}
			// 无自增 id 返回 0
			$roleRes = $this -> _db -> insert('mg_roleuser', array('role_id'=>$role_id,'uid'=>$result));
			$role_data['role_id']  = $role_id;
			$role_data['role_uid'] = $result;
			
			// 记录日志
			log_record(session('uid'), '添加管理员角色', $role_data);
			
			$info = array('status' => 1, 'info' => '操作成功');
		}
		$this -> ajaxReturn($info);
	}
	
	// 编辑管理员页面
	public function editAction() {
		
		$id = I('get.id', 0, 'intval');
		
		if(!$id){
			exit('用户信息错误');
		}
		// 判断，不能修改超级管理员的
		if($id == 1){
			exit('用户信息错误');
		}
		
		$field = array('id', 'name', 'nickname');
		$where = array('id[=]' => $id, 'LIMIT' => 1);
		$lists = array();
		$lists = $this -> _db -> select('mg_users', $field, $where); // 二维数组
		if(!$lists){
			exit('用户信息错误');
		}
		
		$this -> getView() -> assign('rolelists', $this->getRoleList($lists[0]['id'])); // 角色组选择框
		$this -> getView() -> assign('lists', $lists[0]);
		$this -> getView() -> display('users/edit.html');
	}
	
	// 保存编辑管理员
	public function editsaveAction() {
		$inputs 	= I('post.');
		$id 		= I('post.id', 0, 'intval');
		$name 		= $inputs['name'];
		$nickname 	= $inputs['nickname'];
		$role_id 	= I('post.rid', 0, 'intval');
		
		// 判断
		if(!$id){
			$this -> ajaxReturn(array('status' => 0, 'info' => '用户信息错误'));
		}
		// 不能修改超级管理员的
		if($id == 1){
			$this -> ajaxReturn(array('status' => 0, 'info' => '用户信息错误'));
		}
		if(!$name){
			$this -> ajaxReturn(array('status' => 0, 'info' => '请输入用户名'));
		}
		if(!$role_id){
			$this -> ajaxReturn(array('status' => 0, 'info' => '请为该用户分配一个角色'));
		}
		
		// 检查 id
		$field = array('id');
		$where = array('id[=]' => $id, 'LIMIT' => 1);
		$lists = array();
		$lists = $this -> _db -> select('mg_users', $field, $where); // 二维数组
		if(!$lists){
			$this -> ajaxReturn(array('status' => 0, 'info' => '用户信息错误'));
		}
		
		// 保存用户信息
		$data['name'] 			= $name;
		$data['nickname'] 		= $nickname;
		
		$this -> _db -> update('mg_users', $data, array('id'=>$lists[0]['id']));
		
		// 记录日志
		log_record(session('uid'), '编辑管理员', $data);
		
		// 保存角色
		$roleHas = $this -> _db -> select('mg_roleuser', array('uid'), array('uid[=]'=>$lists[0]['id'], 'LIMIT'=>1));
		if($roleHas){
			// 存在则删除
			$this -> _db -> delete('mg_roleuser', array('uid[=]'=>$lists[0]['id']));
		}
		// 无自增 id 返回 0
		$roleRes = $this -> _db -> insert('mg_roleuser', array('role_id'=>$role_id,'uid'=>$lists[0]['id']));
		$role_data['role_id']  = $role_id;
		$role_data['role_uid'] = $lists[0]['id'];
		
		// 记录日志
		log_record(session('uid'), '编辑管理员角色', $role_data);
		
		$info = array('status' => 1, 'info' => '操作成功');
		
		$this -> ajaxReturn($info);
	}
	
	// 重置密码
	public function repasswdAction() {
		$id 	= I('post.id', 0, 'intval');
		$passwd = I('post.passwd');
		
		// 判断
		if(!$id){
			$this -> ajaxReturn(array('status' => 0, 'info' => '用户信息错误'));
		}
		// 不能修改超级管理员的
		if($id == 1){
			$this -> ajaxReturn(array('status' => 0, 'info' => '用户信息错误'));
		}
		if(!$passwd){
			$this -> ajaxReturn(array('status' => 0, 'info' => '请输入新密码'));
		}
		
		// 检查 id
		$field = array('id');
		$where = array('id[=]' => $id, 'LIMIT' => 1);
		$lists = array();
		$lists = $this -> _db -> select('mg_users', $field, $where); // 二维数组
		if(!$lists){
			$this -> ajaxReturn(array('status' => 0, 'info' => '用户信息错误'));
		}
		
		// 保存用户信息
		$data['passwd'] = manager_password($passwd);
		
		$result = $this -> _db -> update('mg_users', $data, array('id'=>$lists[0]['id']));
		
		$info = array('status' => 0, 'info' => '操作失败或没有数据更新');
		if($result){
			// 记录日志
			log_record(session('uid'), '重置密码', array('用户id' => $lists[0]['id']));
			
			$info = array('status' => 1, 'info' => '操作成功');
		}
		$this -> ajaxReturn($info);
	}
	
	// 编辑管理员的状态
	public function editstatusAction() {
		$id = I('post.id', 0, 'intval');
		
		// 判断
		if(!$id){
			$this -> ajaxReturn(array('status' => 0, 'info' => '用户信息错误'));
		}
		// 不能修改超级管理员的
		if($id == 1){
			$this -> ajaxReturn(array('status' => 0, 'info' => '用户信息错误'));
		}
		
		// 检查 id
		$field = array('id', 'status');
		$where = array('id[=]' => $id, 'LIMIT' => 1);
		$lists = array();
		$lists = $this -> _db -> select('mg_users', $field, $where); // 二维数组
		if(!$lists){
			$this -> ajaxReturn(array('status' => 0, 'info' => '用户信息错误'));
		}
		
		// 变为 一维数组
		$lists = $lists[0];
		
		// 判断管理员状态
		$status = 1;
		if($lists['status']){
			$status = 0; // 禁用
		}
		
		// 保存用户信息
		$data['status'] = $status;
		
		$result = $this -> _db -> update('mg_users', $data, array('id'=>$lists['id']));
		
		$info = array('status' => 0, 'info' => '操作失败或没有数据更新');
		if($result){
			// 记录日志
			log_record(session('uid'), '编辑管理员状态', array('用户id' => $lists['id'], '状态' => $status));
			
			$info = array('status' => 1, 'info' => '操作成功');
		}
		$this -> ajaxReturn($info);
	}
	
	// 输出角色选择框
	private function getRoleList($uid = 0) {
		// 输出角色
		$field = array('id', 'name');
		$where = array('status[=]' => 1); // 启用的角色
		$rolelists = $this -> _db -> select('mg_role', $field, $where);
		
		$role_id = '';
		if($uid){
			// 输出所在角色组
			$role_id = $this -> _db -> select('mg_roleuser', array('role_id'), array('uid[=]'=>$uid, 'LIMIT'=>1));
			if($role_id){
				$role_id = $role_id[0]['role_id'];
			}
		}
		
		$roleBox = '';
		foreach($rolelists as $key => $val){
			$roleBox .= '<label class="radio-inline">';
			if($role_id && ($role_id == $val['id'])){
				$roleBox .= '<input type="radio" name="rid" value="' . $val['id'] . '" checked="checked" />' .  $val['name'];
			}else{
				$roleBox .= '<input type="radio" name="rid" value="' . $val['id'] . '" />' .  $val['name'];
			}
			$roleBox .= '</label>';
		}
		return $roleBox;
	}
	
}
