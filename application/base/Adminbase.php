<?php
/*
** 后台公共基类控制器，后台所有相关控制器都要继承它(除登陆控制器)
*/

class AdminbaseController extends BaseController {
	private $_uid; // 当前登陆的管理员 id
	private $_controller; 	// 控制器名称
	private $_action; 		// 方法名称
	private $_db;
	
	// 自动优先加载
	public function init() {
		parent::init();
		
		$this -> _uid = session('uid');
		if(! $this -> _uid){
			// 未登陆，跳转到登陆页
			header('Location:/public/login');
			exit();
		}
		
		// 实例化数据库
		$this -> _db = new medoo();
		
		// 获取 当前控制器名称、方法名称，供权限验证使用
		$this -> _controller 	= $this -> getRequest() -> controller;
		$this -> _action 		= $this -> getRequest() -> action;
		// 当前提交的方式类型
		$actype = $this -> getRequest() -> method;
		
		// 即时检查当前登陆管理员是否具有当前控制器、方法的权限
		if($this -> _uid == 1){
			// 如果是超级管理员，直接通过
		}else{
			$chkRes = $this -> auth_check($this -> _uid);
			if(!$chkRes){
				if(is_ajax()){ // ajax 方式
					$this -> ajaxReturn(array('status' => 0, 'info' => '您的权限不足！'));
				}else{
					$errMsg = array('errmsg'=>'您的权限不足！','reurl'=>$_SERVER['HTTP_REFERER']);
					$this -> getView() -> assign($errMsg);
					$this -> getView() -> display(VIEW_PATH . 'public/error.html');
					exit();
				}
			}
		}
	}
	
	
/************* 以下为 按权限 获取后台左侧树形菜单 *****************/
	
	/*
	** 菜单树状结构集合
	*/
	protected function menu_json() {
		$data = $this->get_tree(0);
		return $data;
	}
	
	/*
	** 按父ID查找菜单子项
	** @param integer $pid   父菜单ID
	** @param integer $with_self  是否包括他自己
	*/
	private function admin_menu($pid, $with_self = false) {
		//父节点ID
		$pid = (int) $pid;
		
		$field = '*';
		$where = array(
				'AND' 	=> array('pid[=]' => $pid, 'status[=]' => 1),
				//'AND' 	=> array('pid[=]' => $pid),
				'ORDER' => array('path'=>'ASC')
			);
		$result = $this -> _db -> select('mg_menu', $field, $where);
		
		if($with_self){
			$result2[] = $this->where(array('id' => $pid))->find();
			$result = array_merge($result2, $result);
		}
		
		//权限检查
		if($this->_uid == 1){
			//如果是超级管理员 直接通过
			return $result;
			exit;
		}
		
		$array = array();
		foreach($result as $v){
			$rule_name = strtolower($v['model'] . '/' . $v['action']);
			
			// 权限验证是否具有菜单权限
			if($this->auth_check($this->_uid, $rule_name)){
				$array[] = $v;
			}
		}
		return $array;
	}
	
	/*
	** 获取菜单 头部菜单导航
	** @param $pid 菜单id
	*/
	private function submenu($pid = '', $big_menu = false) {
		$array = $this->admin_menu($pid, 1);
		$numbers = count($array);
		if($numbers == 1 && !$big_menu){
			return '';
		}
		return $array;
	}
	
	//取得树形结构的菜单
	private function get_tree($myid, $parent = '', $Level = 1) {
		$data = $this->admin_menu($myid);
		$Level++;
		if(is_array($data)){
			$ret = NULL;
			foreach($data as $a){
				$id = $a['id'];
				$model = ucwords($a['model']);
				$action = $a['action'];
				
				$array = array(
					'icon' 		=> $a['icon'] ? $a['icon'] : 'desktop',
					'id' 		=> $id . $model,
					'name' 		=> $a['name'],
					'parent' 	=> $parent,
					'url' 		=> $model . '/' . $action
				);
				
				$ret[$id . $model] = $array;
				$child = $this->get_tree($a['id'], $id, $Level);
				//由于后台管理界面只支持三层，超出的层级不显示
				if($child && $Level <= 3){
					$ret[$id . $model]['items'] = $child;
				}
			}
			return $ret;
		}
		return false;
	}
/************* 以上为获取后台左侧树形菜单 *****************/

	/*
	** 检查权限
	** @param name string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
	** @param uid  int           认证用户的id
	** @param relation string    如果为 'or' 表示满足任一条规则即通过验证;
	** 如果为'and'则表示需满足所有规则才能通过验证
	** @return boolean           通过验证返回true;失败返回false
	*/
	private function auth_check($uid, $name = null, $relation = 'or') {
		if(empty($uid)){
			return false;
		}
		
		$uid = intval($uid);
		
		if($uid == 1){
			// 如果是超级管理员，直接通过
			return true;
		}
		
		if(empty($name)){
			// 检查当前控制器和方法
			$name = strtolower($this->_controller . '/' . $this->_action);
		}else{
			$name = strtolower($name);
		}
		
		// 首先检查当前登陆用户是否在对应的角色组里，二维数组
		// 即检查用户的合法性，注意顺序(同登陆)
		$roleUser = $this -> _db -> select('mg_roleuser', array('role_id'), array('uid'=>$uid,'LIMIT'=>1));
		if($roleUser){
			// 二维数组
			$roleLists = $this -> _db -> select('mg_role', array('id', 'status'), array('id'=>$roleUser[0]['role_id'],'LIMIT'=>1));
			if(!$roleLists || $roleLists[0]['status'] == 0){
				return false;
			}
			// 如果是超级管理员角色组，直接通过
			if($roleLists[0]['id'] == 1){
				return true;
			}
			// 检查是否已给角色分配权限
			$roleAccess = $this -> _db -> select('mg_authaccess', array('role_id'), array('role_id'=>$roleUser[0]['role_id'])); // 二维数组
			if(!$roleAccess){
				return false;
			}
		}else{
			return false;
		}
		
		// 按权限检查
		$trueLists = array();
		
		$accessLists = $this -> _db -> select('mg_authaccess', array('rule_name'), array('role_id'=>$roleLists[0]['id']));
		
		foreach($accessLists as $accRule){
			$rule_name = strtolower($accRule['rule_name']);
			if($rule_name == $name){
				$trueLists[] = $rule_name;
			}
		}
		
		// 有就通过
		if($relation == 'or' && $trueLists){
			return true;
		}
		/* 两个参数都是数组才行
		// 全部有才能通过
		$diff = array_diff($name, $trueLists);
		if($relation == 'and' && empty($diff)){
			return true;
		}
		*/
		
		return false;
	}
	
	// 输出城市下拉列表
	protected function showDistrict($prov_id = 110000, $city_id = 110100, $area_id = 110101) {
		
		// 输出省份列表，默认 北京
		$fieldProv = '*';
		$whereProv = array('AND' => array('level[=]' => 1, 'upid[=]' => 0,));
		$listsProv = $this -> _db -> select('district', $fieldProv, $whereProv);
		$dataProv = '';
		foreach($listsProv as $kp => $vp) {
			$dataProv .= '<option ';
			if($prov_id == $vp['id']){
				$dataProv .= ' selected="selected" ';
			}
			$dataProv .= ' value ="' . $vp['id'] . '">' . $vp['name'] . '</option>';
		}
		
		// 输出城市列表
		$fieldCity = '*';
		$whereCity = array('AND' => array('level[=]' => 2, 'upid[=]' => $prov_id));
		$listsCity = $this -> _db -> select('district', $fieldCity, $whereCity);
		$dataCity = '';
		foreach($listsCity as $kc => $vc) {
			$dataCity .= '<option ';
			if($city_id == $vc['id']){
				$dataCity .= ' selected="selected" ';
			}
			$dataCity .= ' value ="' . $vc['id'] . '">' . $vc['name'] . '</option>';
		}
		
		// 输出县州区列表
		$fieldArea = '*';
		$whereArea = array('AND' => array('level[=]' => 3, 'upid[=]' => $city_id));
		$listsArea = $this -> _db -> select('district', $fieldArea, $whereArea);
		$dataArea = '';
		foreach($listsArea as $ka => $va) {
			$dataArea .= '<option ';
			if($area_id == $va['id']){
				$dataArea .= ' selected="selected" ';
			}
			$dataArea .= ' value ="' . $va['id'] . '">' . $va['name'] . '</option>';
		}
		
		return array('provlists' => $dataProv, 'citylists' => $dataCity, 'arealists' => $dataArea);
	}
	
}
