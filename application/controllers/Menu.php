<?php
/*
** 后台菜单控制器
*/

class MenuController extends AdminbaseController {
	protected $_db;
	// 自动优先加载
	public function init() {
		parent::init();
		
		$this -> _db = new medoo();
	}
	
	// 菜单列表页面
	public function indexAction() {
		
		$field = '*';
		$where = array();
		$lists = array();
		$lists = $this -> _db -> select('mg_menu', $field, $where);
		// 替换
		foreach($lists as $key => &$val){
			$url = $val['model'] . '/' . $val['action'];
			$val['url'] = strtolower($url);
			$val['name'] = get_tree_icons($val['path']) . $val['name'];
			$val['pnode'] = $val['pid'] ? 'child-of-node-' . $val['pid'] : ''; // 节点
			unset($val['model']);
			unset($val['action']);
		}
		
		$this -> getView() -> assign('lists', $lists);
		$this -> getView() -> display('menu/index.html');
	}
	
	// 添加菜单页面
	public function addAction() {
		
		$field = array('id', 'name', 'path');
		$where = array();
		$lists = array();
		$lists = $this -> _db -> select('mg_menu', $field, $where);
		
		// 上级菜单 下拉菜单
		$menulists = '<select class="form-control width400" name="pid">';
		$menulists .= '<option value="0">作为顶级菜单</option>';
		foreach($lists as $key => $val){
			$menulists .= '<option value="' . $val['id'] . '">' . get_tree_icons($val['path']) . $val['name'] . '</option>';
		}
		$menulists .= '</select>';
		
		$this -> getView() -> assign('menulists', $menulists);
		$this -> getView() -> display('menu/add.html');
	}
	
	// 保存添加菜单
	public function addsaveAction() {
		$inputs = I('post.');
		
		// 验证数据
		$this -> checkData($inputs);
		
		$pid = intval($inputs['pid']);
		$pid = $pid > 0 ? $pid : 0;
		
		// 处理菜单级数
		if($pid){
			// 验证 上级菜单
			$parent = $this -> _db -> select('mg_menu', array('path'), array('id[=]'=>$pid,'LIMIT'=>1));
			if(!$parent){
				$this -> ajaxReturn(array('status' => 0, 'info' => '上级菜单参数错误'));
			}
			
			// 二维数组变一维
			$parent = $parent[0];
			
			$pPath = explode('-', $parent['path']);
			// 处理 level
			$level = count($pPath) - 1;
			if($level >= 5){
				$this -> ajaxReturn(array('status' => 0, 'info' => '菜单级数不能超过 5 级'));
			}
		}
		
		// 验证菜单名称是否唯一
		$Only = $this -> _db -> select('mg_menu', array('id'), array('name[=]'=>$inputs['name'],'LIMIT'=>1));
		if($Only){
			$this -> ajaxReturn(array('status' => 0, 'info' => '菜单名称不能重复'));
		}
		
		// 验证控制器、方法是否唯一
		$OnlyOO = $this -> _db -> select('mg_menu', array('id'), array('AND'=>array('model[=]'=>$inputs['model'],'action[=]'=>$inputs['action']),'LIMIT'=>1));
		if($OnlyOO){
			$this -> ajaxReturn(array('status' => 0, 'info' => '控制器、方法名称不能重复'));
		}
		
		// 保存菜单信息
		$data['pid'] 		= $pid;
		$data['name'] 		= $inputs['name'];
		$data['model'] 		= $inputs['model'];
		$data['action'] 	= $inputs['action'];
		$data['icon'] 		= $inputs['icon'];
		$data['status'] 	= intval($inputs['status']);
		$data['type'] 		= intval($inputs['type']);
		
		$result = $this -> _db -> insert('mg_menu', $data);
		
		// 处理 path、level
		if($pid){
			$path = $parent['path'] . '-' . $result;
			$topid = $pPath[1]; // 0-1 中 1 的位置
		}else{
			$path  = '0-' . $result;
			$topid = 0;
		}
		
		// 更新 path
		$res = $this -> _db -> update('mg_menu', array('topid'=>$topid,'path'=>$path), array('id[=]'=>$result));
		
		$info = array('status' => 0, 'info' => '操作失败');
		if($res){
			// 记录日志
			log_record(session('uid'), '添加后台菜单', array_merge($data,array('topid'=>$topid,'path'=>$path)));
			
			$info = array('status' => 1, 'info' => '操作成功');
		}
		$this -> ajaxReturn($info);
	}
	
	// 编辑菜单页面
	public function editAction() {
		
		$id = I('get.id', 0, 'intval');
		
		// 验证 id
		if(!$id){
			exit('参数错误');
		}
		$lists = $this -> _db -> select('mg_menu', '*', array('id[=]'=>$id)); // 二维数组
		if(!$lists){
			exit('参数错误');
		}
		
		// 二维数组变一维
		$lists = $lists[0];
		
		// 获取上级菜单名称
		if($lists['pid']){
			$lists['pname'] = get_menu_name($lists['pid']);
		}else{
			$lists['pname'] = '作为顶级菜单';
		}
		
		$this -> getView() -> assign('lists', $lists);
		$this -> getView() -> display('menu/edit.html');
	}
	
	// 保存编辑菜单
	public function editsaveAction() {
		$inputs = I('post.');
		
		// 验证数据
		$this -> checkData($inputs);
		
		$id = intval($inputs['id']);
		$id = $id > 0 ? $id : 0;
		
		// 验证 id
		if(!$id){
			$this -> ajaxReturn(array('status' => 0, 'info' => '参数错误'));
		}
		$lists = $this -> _db -> select('mg_menu', array('id'), array('id[=]'=>$id,'LIMIT'=>1));
		if(!$lists){
			$this -> ajaxReturn(array('status' => 0, 'info' => '参数错误'));
		}
		// 变为一维数组
		$lists = $lists[0];
		
		// 验证菜单名称是否唯一
		$Only = $this -> _db -> select('mg_menu', array('id'), array('name[=]'=>$inputs['name'],'LIMIT'=>1));
		if($Only && $Only[0]['id'] != $lists['id']){
			// 错误
			$this -> ajaxReturn(array('status' => 0, 'info' => '菜单名称不能重复'));
		}
		
		// 验证控制器、方法是否唯一
		$OnlyOO = $this -> _db -> select('mg_menu', array('id'), array('AND'=>array('model[=]'=>$inputs['model'],'action[=]'=>$inputs['action']),'LIMIT'=>1));
		
		if($OnlyOO && $OnlyOO[0]['id'] != $lists['id']){
			// 错误
			$this -> ajaxReturn(array('status' => 0, 'info' => '控制器、方法名称不能重复'));
		}
		
		// 保存菜单信息
		$data['name'] 		= $inputs['name'];
		$data['model'] 		= $inputs['model'];
		$data['action'] 	= $inputs['action'];
		$data['icon'] 		= $inputs['icon'];
		$data['status'] 	= intval($inputs['status']);
		$data['type'] 		= intval($inputs['type']);
		
		$result = $this -> _db -> update('mg_menu', $data, array('id[=]'=>$lists['id']));
		
		$info = array('status' => 0, 'info' => '操作失败');
		if($result){
			// 记录日志
			log_record(session('uid'), '编辑后台菜单', $data);
			
			$info = array('status' => 1, 'info' => '操作成功');
		}
		$this -> ajaxReturn($info);
	}
	
	// 验证数据
	private function checkData($datas) {
		if(!$datas['name']){
			$this -> ajaxReturn(array('status' => 0, 'info' => '请输入菜单名称'));
		}
		if(!$datas['model']){
			$this -> ajaxReturn(array('status' => 0, 'info' => '请输入控制器名称'));
		}
		if($datas['status'] == 0 || $datas['status'] == 1){
			// 正确范围
		}else{
			$this -> ajaxReturn(array('status' => 0, 'info' => '请选择正确的菜单状态'));
		}
		if($datas['type'] == 0 || $datas['type'] == 1){
			// 正确范围
		}else{
			$this -> ajaxReturn(array('status' => 0, 'info' => '请选择正确的菜单类型'));
		}
	}
	
}
