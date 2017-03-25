<?php
/*
** 后台登陆控制器
*/

class PublicController extends BaseController {
	// 自动优先加载
	public function init() {
		parent::init();
	}
	
	// 后台登陆界面
	public function loginAction() {
		$uid = session('uid');
		if($uid){
			// 已登陆，跳转到后台首页
			header('Location:/');
			exit();
		}else{
			$this -> getView() -> display('public/login.html');
		}
	}
	
	// 注销登陆
	public function logoutAction() {
		// 记录日志
		log_record(session('uid'), '注销', array());
		
		// 执行 SSO 单点登陆注销
		//done_sso('logout');
		
		// 清空 session
		session(null);
		$this -> success('注销成功', array('url' => '/public/login'));
	}
	
	// 处理登陆事件
	public function dologinAction() {
		// 处理提交的数据
		$queryData = $_POST;
		
		// 检测数据
		$this -> checkDatas($queryData);
		
		$name = $queryData['username'];
		$pass = $queryData['password'];
		
		$result = array();
		// 实例化数据库
		$Users = new medoo();
		
		// 检测用户名
		$field = '*'; // * 查询所有字段
		$where = array('name[=]' => $name);
		$result = $Users -> get('mg_users', $field, $where);
		
		if(!$result){
			$this -> error('用户信息错误', array('refresh' => 1));
		}
		
		// 检测密码
		$passwd = manager_password($pass);
		if($passwd != $result['passwd']){
			$this -> error('用户信息错误', array('refresh' => 1));
		}
		
		// 检测用户状态，0 禁用 1 正常
		if($result['status'] == 0){
			$this -> error('用户信息错误', array('refresh' => 1));
		}
		
		// 检测用户权限，先检查是否在管理组，以及是否启用
		if($result['id'] == 1){ // 如果是超级管理员
			// 不处理
		}else{
			$roleUser = $Users -> select('mg_roleuser', array('role_id'), array('uid'=>$result['id'],'LIMIT'=>1)); // 二维数组
			if($roleUser){
				$roleStatus = $Users -> select('mg_role', array('status'), array('id'=>$roleUser[0]['role_id'],'LIMIT'=>1)); // 二维数组
				if(!$roleStatus || $roleStatus[0]['status'] == 0){
					$this -> error('用户信息错误', array('refresh' => 1));
				}
				// 检查是否已给角色分配权限
				$roleAccess = $Users -> select('mg_authaccess', array('role_id'), array('role_id'=>$roleUser[0]['role_id'])); // 二维数组
				if(!$roleAccess){
					$this -> error('用户信息错误', array('refresh' => 1));
				}
			}else{
				$this -> error('用户信息错误', array('refresh' => 1));
			}
		}
		
		// 登入成功，把管理员信息放入 session里，并页面跳转
		session('uid', $result['id']);
		session('username', $result['name']);
		session('nickname', $result['nickname']);
		session('login_ip', $result['login_ip']);
		session('login_time', $result['time_login']);
		session('login_count', $result['login_count'] + 1);
		
		// 更新用户登陆信息
		$data['login_ip'] 		= ip2long(get_client_ip(0, true));
		$data['time_login'] 	= time();
		$data['login_count'] 	= $result['login_count'] + 1;
		$Users -> update('mg_users', $data, array('id'=>$result['id']));
		
		// 记录日志
		log_record(session('uid'), '登陆', $data);
		
		// 检查执行 SSO 单点登陆
		//done_sso('login');
		
		$this -> success('登陆成功', array('url' => '/'));
	}
	
	// 生成验证码
	public function verifyAction() {
		$config = array(
				'fontSize' 	=> 30, 		// 验证码字体大小
				'length' 	=> 5, 		// 验证码位数
				'useNoise' 	=> false, 	// 是否启用验证码杂点
		);
		
		$Verify = new verify($config);
		$Verify -> entry();
	}
	
	// 检测验证码
	private function checkVerify($code) {
		$Verify = new verify();
		return $Verify -> check($code);
	}
	
	// 检测数据
	private function checkDatas($datas) {
		$name = $datas['username'];
		$pass = $datas['password'];
		$code = $datas['verify'];
		
		if(! $name){
			$this -> error('用户名不能为空');
		}
		
		if(! $pass){
			$this -> error('密码不能为空');
		}
		
		if(! $code){
			$this -> error('验证码不能为空');
		}
		
		// 检测验证码
		if(! $this -> checkVerify($code)){
			$this -> error('验证码错误', array('refresh' => 1));
		}
	}
	
}
