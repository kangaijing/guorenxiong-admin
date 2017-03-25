<?php
/*
** 后台基类控制器，后台登陆直接继承此控制器
*/

class BaseController extends Yaf_Controller_Abstract {
	// 自动优先加载
	public function init() {
		// 检测后台 url 密码
		$config = Yaf_Application::app() -> getConfig() -> get('encrypt');
		$ufw_passwd = $config['ufw'];
		
		// 如果设置了后台 url 密码
		if($ufw_passwd){
			$ufw_session = session('ufwpasswd');
			// session 存在
			if($ufw_session){
				if($ufw_session == $ufw_passwd){
					// 正确
				}else{
					// 如果在配置文件新修改了后台 url 密码
					session(null);
					header('Location:http://www.baidu.com');
					exit();
				}
			}else{
				$ufw_input = I('get.ufw');
				if($ufw_input && ($ufw_input == $ufw_passwd)){
					session('ufwpasswd', $ufw_passwd);
				}else{
					session(null);
					header('Location:http://www.baidu.com');
					exit();
				}
			}
		}
		
	}
	
	/*
	** 返回 json 数据格式到客户端 包含状态信息
	** @param mixed $data 要返回的数据
	*/
	protected function ajaxReturn($data) {
		// 返回JSON数据格式到客户端 包含状态信息
		header('Content-Type:application/json; charset=utf-8');
		exit(json_encode($data, 0));
	}
	
	/*
	** 成功返回 json 数据到客户端
	** @param string $msg 要返回的信息字符串
	** @param array $datas 要返回的信息数组数据
	*/
	protected function success($msg = '', $datas = array()) {
		if(!$msg){
			return false;
		}
		$datas['status'] = 1;
		$datas['info'] = $msg;
		$this -> ajaxReturn($datas);
	}
	
	/*
	** 失败返回 json 数据到客户端
	** @param string $msg 要返回的信息字符串
	** @param array $datas 要返回的信息数组数据
	*/
	protected function error($msg = '', $datas = array()) {
		if(!$msg){
			return false;
		}
		$datas['status'] = 0;
		$datas['info'] = $msg;
		$this -> ajaxReturn($datas);
	}
	
}
