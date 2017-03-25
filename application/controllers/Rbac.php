<?php
/*
** 管理员角色权限控制器
*/

class RbacController extends AdminbaseController {
	protected $_db;
	// 自动优先加载
	public function init() {
		parent::init();
		
		$this -> _db = new medoo();
	}
	
	// 角色列表页面
	public function indexAction() {
		
		$field = '*';
		$where = array();
		$lists = array();
		$lists = $this -> _db -> select('mg_role', $field, $where);
		
		$this -> getView() -> assign('lists', $lists);
		$this -> getView() -> display('rbac/index.html');
	}
	
	// 添加角色页面
	public function addAction() {
		
		$this -> getView() -> display('rbac/add.html');
	}
	
	// 保存添加角色
	public function addsaveAction() {
		$inputs = I('post.');
		
		$name 		= $inputs['name'];
		$remark 	= $inputs['remark'];
		$status 	= I('post.status', 0, 'intval');
		
		// 判断
		if(!$name){
			$this -> ajaxReturn(array('status' => 0, 'info' => '请输入角色名称'));
		}
		// 判断 角色名称 是否重复
		$Only = $this -> _db -> select('mg_role', array('id'), array('name[=]'=>$name, 'LIMIT'=>1));
		if($Only){
			$this -> ajaxReturn(array('status' => 0, 'info' => '角色名称不能重复'));
		}
		if($status == 0 || $status == 1){
			// 正确
		}else{
			$this -> ajaxReturn(array('status' => 0, 'info' => '请选择正确的状态'));
		}
		
		// 保存角色信息
		$data['name'] 		= $name;
		$data['remark'] 	= $remark;
		$data['status'] 	= $status;
		
		$result = $this -> _db -> insert('mg_role', $data);
		
		$info = array('status' => 0, 'info' => '操作失败');
		if($result){
			// 记录日志
			log_record(session('uid'), '添加角色', $data);
			
			$info = array('status' => 1, 'info' => '操作成功');
		}
		$this -> ajaxReturn($info);
	}
	
	// 编辑角色页面
	public function editAction() {
		
		$id = I('get.id', 0, 'intval');
		
		if(!$id){
			exit('角色信息错误');
		}
		// 判断，不能修改超级管理员的
		if($id == 1){
			exit('角色信息错误');
		}
		
		$field = '*';
		$where = array('id[=]' => $id, 'LIMIT' => 1);
		$lists = array();
		$lists = $this -> _db -> select('mg_role', $field, $where); // 二维数组
		
		if(!$lists){
			exit('角色信息错误');
		}
		
		$this -> getView() -> assign('lists', $lists[0]);
		$this -> getView() -> display('rbac/edit.html');
	}
	
	// 保存编辑角色
	public function editsaveAction() {
		$inputs = I('post.');
		$id 		= I('post.id', 0, 'intval');
		$name 		= $inputs['name'];
		$remark 	= $inputs['remark'];
		$status 	= I('post.status', 0, 'intval');
		
		// 判断
		if(!$id){
			$this -> ajaxReturn(array('status' => 0, 'info' => '用户信息错误'));
		}
		if($id == 1){ // 不能编辑 超级管理员
			$this -> ajaxReturn(array('status' => 0, 'info' => '用户信息错误'));
		}
		if(!$name){
			$this -> ajaxReturn(array('status' => 0, 'info' => '请输入角色名称'));
		}
		if($status == 0 || $status == 1){
			// 正确
		}else{
			$this -> ajaxReturn(array('status' => 0, 'info' => '请选择正确的状态'));
		}
		
		// 检查 id
		$field = array('id');
		$where = array('id[=]' => $id, 'LIMIT' => 1);
		$lists = array();
		$lists = $this -> _db -> select('mg_role', $field, $where); // 二维数组
		if(!$lists){
			$this -> ajaxReturn(array('status' => 0, 'info' => '角色信息错误'));
		}
		
		// 判断 角色名称 是否重复
		$Only = $this -> _db -> select('mg_role', array('id'), array('name[=]'=>$name, 'LIMIT'=>1));
		if($Only){
			if($Only[0]['id'] == $lists[0]['id']){
				// 正确
			}else{
				$this -> ajaxReturn(array('status' => 0, 'info' => '角色名称不能重复'));
			}
		}
		
		// 保存角色信息
		$data['name'] 		= $name;
		$data['remark'] 	= $remark;
		$data['status'] 	= $status;
		
		$result = $this -> _db -> update('mg_role', $data, array('id'=>$lists[0]['id']));
		
		$info = array('status' => 0, 'info' => '操作失败或没有数据更新');
		if($result){
			// 记录日志
			log_record(session('uid'), '编辑角色', $data);
			
			$info = array('status' => 1, 'info' => '操作成功');
		}
		$this -> ajaxReturn($info);
	}
	
	// 角色权限设置页面
	public function authorizeAction() {
		$role_id = I('get.id', 0, 'intval');
		if(!$role_id){
			exit('角色信息错误');
		}
		// 判断，不能修改超级管理员的
		if($role_id == 1){
			exit('角色信息错误');
		}
		// 获取已经分配的权限
		$roleLists = $this -> _db -> select('mg_authaccess', '*', array('role_id'=>$role_id));
		
		$roleArray = array();
		if($roleLists){
			foreach($roleLists as $rkey => $rval){
				$roleArray[] = $rval['rule_name'];
			}
		}
		
		// 获取后台顶级菜单
		$field = array('id', 'pid', 'topid', 'model', 'action', 'name');
		// 二维数组
		$lists = $this -> _db -> select('mg_menu', $field, array('pid'=>0));
		
		$rbacMenu = '';
		// 获取子菜单
		foreach($lists as $key => $val){
			$semenu = $this -> _db -> select('mg_menu', $field, array('topid[=]'=>$val['id']));
			
			$rbacMenu .= '<div class="panel panel-info">';
			$rbacMenu .= '<div class="panel-heading"><div class="checkbox"><label>';
			$roleOne = $val['model'] . '/' . $val['action'];
			if($roleArray && in_array($roleOne, $roleArray)){ // 标示已获取的权限
				$rbacMenu .= '<input type="checkbox" class="rolecheck firmenuall" name="ids[]" value="' . $val['id'] . '" checked="checked">' . $val['name'];
			}else{
				$rbacMenu .= '<input type="checkbox" class="rolecheck firmenuall" name="ids[]" value="' . $val['id'] . '">' . $val['name'];
			}
			$rbacMenu .= '</label></div></div>';
			if($semenu){
				$rbacMenu .= '<div class="panel-body">';
				$rbacMenu .= '<ul>';
				foreach($semenu as $skey => $sval){
					$roleTwo = $sval['model'] . '/' . $sval['action'];
					if($sval['pid'] == $val['id']){
						$rbacMenu .= '<li class="semenus"><div class="checkbox"><label>';
						
						if($roleArray && in_array($roleTwo, $roleArray)){ // 标示已获取的权限
							$rbacMenu .= '<input type="checkbox" class="rolecheck semenu' . $val['id'] . '" name="ids[]" value="' . $sval['id'] . '" checked="checked"> ' . $sval['name'];
						}else{
							$rbacMenu .= '<input type="checkbox" class="rolecheck semenu' . $val['id'] . '" name="ids[]" value="' . $sval['id'] . '"> ' . $sval['name'];
						}
						$rbacMenu .= '</label></div></li>';
					}else{
						$rbacMenu .= '<li><div class="checkbox"><label>';
						if($roleArray && in_array($roleTwo, $roleArray)){ // 标示已获取的权限
							$rbacMenu .= '<input type="checkbox" class="rolecheck semenu' . $val['id'] . '" name="ids[]" value="' . $sval['id'] . '" checked="checked"> ' . $sval['name'];
						}else{
							$rbacMenu .= '<input type="checkbox" class="rolecheck semenu' . $val['id'] . '" name="ids[]" value="' . $sval['id'] . '"> ' . $sval['name'];
						}
						$rbacMenu .= '</label></div></li>';
					}
				}
				$rbacMenu .= '<ul>';
				$rbacMenu .= '</div>';
			}
			$rbacMenu .= '</div>';
			
		}
		
		$this -> getView() -> assign('rbacmenu', $rbacMenu);
		$this -> getView() -> assign('role_id', $role_id);
		$this -> getView() -> display('rbac/authorize.html');
	}
	
	// 保存角色权限设置
	public function saveauthorizeAction() {
		$role_id = I('post.id', 0, 'intval');
		$ids = I('post.ids');
		
		if(!$role_id){
			$this -> ajaxReturn(array('status' => 0, 'info' => '角色信息错误'));
		}
		// 判断，不能修改超级管理员的
		if($role_id == 1){
			$this -> ajaxReturn(array('status' => 0, 'info' => '角色信息错误'));
		}
		
		// 处理 权限信息 id
		if($ids){
			$newIds = rtrim($ids, ',');
			$newIds = explode(',', $newIds);
			if($newIds && is_array($newIds)){
				// in 方法查出 对应的菜单信息
				$menuLists = $this -> _db -> select('mg_menu', array('model', 'action'), array('id'=>$newIds));
				if($menuLists){
					// 批量删除旧的权限信息
					$this -> _db -> delete('mg_authaccess', array('role_id'=>$role_id));
					// 组合权限信息
					foreach($menuLists as $key => &$val){
						$val['role_id'] = $role_id;
						$val['rule_name'] = $val['model'] . '/' . $val['action'];
						unset($val['model']);
						unset($val['action']);
					}
					// 批量插入权限信息
					$this -> _db -> insert('mg_authaccess', $menuLists);
					
					$this -> ajaxReturn(array('status' => 1, 'info' => '处理成功'));
				}
			}else{
				$newIds = array();
			}
		}else{
			// 批量删除旧的权限信息
			$this -> _db -> delete('mg_authaccess', array('role_id'=>$role_id));
			
			$this -> ajaxReturn(array('status' => 1, 'info' => '处理成功'));
		}
		
		$this -> ajaxReturn(array('status' => 0, 'info' => '处理失败'));
	}
	
}
