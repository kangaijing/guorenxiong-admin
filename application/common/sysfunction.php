<?php
/*
** 系统函数库
** 函数请带上 sys_ 前缀
*/

/*
** session 处理函数
** @param fix $name 要传入的数组或字符串
** @param strint $value 要传入的 session 值( $name 为字符串时)
*/
function session($name='', $value='') {
	$config = Yaf_Application::app()->getConfig()->get('session');
	$prefix = $config['prefix'];
	
	// 设置 session
	if($name && !is_array($name) && $value){
		// 单个 元素
		if($prefix){
			$_SESSION[$prefix][$name] = $value;
		}else{
			$_SESSION[$name] = $value;
		}
	}
	if($name && is_array($name) && !$value){
		// 数组 元素
		foreach($name as $key => $val){
			if($prefix){
				$_SESSION[$prefix][$key] = $val;
			}else{
				$_SESSION[$key] = $val;
			}
		}
	}
	
	// 获取 session
	if($value === ''){
		// 获取全部的session
		if($name === ''){
            return $prefix ? $_SESSION[$prefix] : $_SESSION;
		}
		// 获取单个 session
		if($name && !is_array($name)){
			if($prefix){
				return isset($_SESSION[$prefix][$name]) ? $_SESSION[$prefix][$name] : null;
			}else{
				return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
			}
		}
		// 清空 整个 session
		if(is_null($name)){
			if($prefix) {
				unset($_SESSION[$prefix]);
			}else{
				$_SESSION = array();
			}
			session_unset();
			session_destroy();
		}
	}
	
	// 删除 单个 session
	if($name && !is_array($name) && is_null($value)){
		if($prefix){
			unset($_SESSION[$prefix][$name]);
		}else{
			unset($_SESSION[$name]);
		}
	}
	
	return null;
}

/*
** 快速文件数据读取和保存 针对简单类型数据：字符串、数组
** @param string $name 缓存名称
** @param mixed $value 缓存值
** @return mixed
*/
function F($name, $value = '') {
	$Filecache = new Filecache();
	static $_cache = array();
	$filename = RUNTIME_PATH . 'data/' . $name . '.php';
	if('' !== $value){
		if(is_null($value)){
			// 删除缓存
			if(false !== strpos($name, '*')){
				return false; // TODO
			}else{
				unset($_cache[$name]);
				return $Filecache -> unlink($filename, 'F');
			}
		}else{
			$Filecache -> put($filename, serialize($value), 'F');
			// 缓存数据
			$_cache[$name] = $value;
			return null;
		}
	}
	// 获取缓存数据
	if(isset($_cache[$name])){
		return $_cache[$name];
	}
	
	if($Filecache -> has($filename, 'F')){
		$value = unserialize($Filecache -> read($filename, 'F'));
		$_cache[$name] = $value;
	}else{
		$value = false;
	}
	return $value;
}

/*
** 后台管理员密码加密方法
** @param string $password 要加密的字符串
** @return string
*/
function manager_password($password) {
	$config 	= Yaf_Application::app()->getConfig()->get('encrypt');
	$authcode 	= $config['manager'];
	$result 	= md5(md5($authcode . $password));
	return $result;
}

/*
** 中医馆负责人密码加密方法
** @param string $password 要加密的字符串
** @return string
*/
function hosdean_password($password) {
	$config 	= Yaf_Application::app()->getConfig()->get('encrypt');
	$authcode 	= $config['hosdean'];
	$result 	= md5(md5($authcode . $password));
	return $result;
}

/*
** 随机字符串生成
** @param int $len 生成的字符串长度
** @return string
*/
function random_string($len = 6) {
	$chars = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k',
			'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v',
			'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G',
			'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
			'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2',
			'3', '4', '5', '6', '7', '8', '9'
	);
	$charsLen = count($chars) - 1;
	shuffle($chars);    // 将数组打乱
	$output = '';
	for ($i = 0; $i < $len; $i++) {
		$output .= $chars[mt_rand(0, $charsLen)];
	}
	return $output;
}

/*
** 获取客户端IP地址
** @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
** @param boolean $adv 是否进行高级模式获取（有可能被伪装）
** @return mixed
*/
function get_client_ip($type = 0,$adv=false) {
	$type       =  $type ? 1 : 0;
	static $ip  =   NULL;
	if($ip !== NULL){
		return $ip[$type];
	}
	if($adv){
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$pos    =   array_search('unknown',$arr);
			if(false !== $pos){
				unset($arr[$pos]);
			}
			$ip     =   trim($arr[0]);
		}elseif(isset($_SERVER['HTTP_CLIENT_IP'])){
			$ip     =   $_SERVER['HTTP_CLIENT_IP'];
		}elseif(isset($_SERVER['REMOTE_ADDR'])){
			$ip     =   $_SERVER['REMOTE_ADDR'];
		}
	}elseif(isset($_SERVER['REMOTE_ADDR'])){
		$ip     =   $_SERVER['REMOTE_ADDR'];
	}
	// IP地址合法验证
	$long = sprintf("%u",ip2long($ip));
	$ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
	return $ip[$type];
}

/*
** 浏览器友好的变量输出
** @param mixed $var 变量
** @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
** @param string $label 标签 默认为空
** @param boolean $strict 是否严谨 默认为true
** @return void|string
*/
function dump($var, $echo=true, $label=null, $strict=true) {
	$label = ($label === null) ? '' : rtrim($label) . ' ';
	if(!$strict){
		if(ini_get('html_errors')){
			$output = print_r($var, true);
			$output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
		}else{
			$output = $label . print_r($var, true);
		}
	}else{
		ob_start();
		var_dump($var);
		$output = ob_get_clean();
		if(!extension_loaded('xdebug')){
			$output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
			$output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
		}
	}
	if($echo){
		echo($output);
		return null;
	}else{
		return $output;
	}
}

/*
** 截取字符串，可以汉字，可以英文，也可以混合
** @param string $str 要截取的字符串
** @param int $length 要截取的长度
*/
function new_substr($str = '', $length = 0, $charset = 'utf-8') {
	$re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
	$re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
	$re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
	preg_match_all($re[$charset], $str, $match);
	// 截取长度等于0或大于等于本字符串的长度，返回字符串本身
	if(count($match[0]) <= $length || $length == 0){
		// 长度小于要截取的长度，返回字符串本身
		$slice = join('', array_slice($match[0], 0, $length));
	}else{
		// 长度大于要截取的长度，返回截取后的字符串，带 ...
		$slice = join('', array_slice($match[0], 0, $length)) . '...';
	}
	return $slice;
}

/*
** 判断是否 SSL 协议
** @return boolean
*/
function is_ssl() {
	if(isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))){
		return true;
	}elseif(isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'] )) {
		return true;
	}
	return false;
}

/*
** URL重定向
** @param string $url 重定向的URL地址
** @param integer $time 重定向的等待时间（秒）
** @param string $msg 重定向前的提示信息
** @return void
*/
function redirect($url, $time=0, $msg='') {
	// 多行URL地址支持
	$url        = str_replace(array("\n", "\r"), '', $url);
	if(empty($msg)){
		$msg    = "系统将在{$time}秒之后自动跳转到{$url}！";
	}
	if(!headers_sent()){
		// redirect
		if(0 === $time){
			header('Location: ' . $url);
		}else{
			header("refresh:{$time};url={$url}");
			echo($msg);
		}
		exit();
	}else{
		$str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
		if($time != 0){
			$str .= $msg;
		}
		exit($str);
	}
}

/*
** 获取输入参数 支持过滤和默认值
** 使用方法:
** <code>
** I('id',0); 获取id参数 自动判断get或者post
** I('post.name','','htmlspecialchars'); 获取$_POST['name']
** I('get.'); 获取$_GET
** </code>
** @param string $name 变量的名称 支持指定类型
** @param mixed $default 不存在的时候默认值
** @param mixed $filter 参数过滤方法
** @return mixed
*/
// 过滤需要函数 1
function array_map_recursive($filter, $data) {
	$result = array();
	foreach ($data as $key => $val) {
		$result[$key] = is_array($val)
			? array_map_recursive($filter, $val)
			: call_user_func($filter, $val);
	}
	return $result;
}
// 过滤需要函数 2
function zhongyi_filter(&$value){ // 过滤查询特殊字符
	if(preg_match('/^(EXP|NEQ|GT|EGT|LT|ELT|OR|XOR|LIKE|NOTLIKE|NOT BETWEEN|NOTBETWEEN|BETWEEN|NOTIN|NOT IN|IN)$/i',$value)){
		$value .= ' ';
	}
}
// 输入过滤函数
function I($name, $default = '', $filter = null) {
	static $_PUT	=	null;
	// 要使用的过滤函数
	static $default_filter	=	'htmlspecialchars,stripslashes,trim';
	$var_to_string = false;
	
	if(strpos($name, '/')){ // 指定修饰符
		list($name,$type) = explode('/', $name, 2);
	}elseif($var_to_string){ // 默认强制转换为字符串
		$type = 's';
	}
	
	if(strpos($name, '.')) { // 指定参数来源
		list($method,$name) = explode('.', $name, 2);
	}else{ // 默认为自动判断
		$method = 'param';
	}
	
	switch(strtolower($method)){
		case 'get' :
			$input =& $_GET;
			break;
		case 'post' :
			$input =& $_POST;
			break;
		case 'put' :
			if(is_null($_PUT)){
				parse_str(file_get_contents('php://input'), $_PUT);
			}
			$input = $_PUT;
			break;
		case 'param' :
			switch($_SERVER['REQUEST_METHOD']){
				case 'POST':
					$input  =  $_POST;
					break;
				case 'PUT':
					if(is_null($_PUT)){
						parse_str(file_get_contents('php://input'), $_PUT);
					}
					$input = $_PUT;
					break;
				default:
					$input = $_GET;
			}
			break;
		case 'request' :
			$input =& $_REQUEST;
			break;
		case 'session' :
			$input =& $_SESSION;
			break;
		case 'cookie'  :
			$input =& $_COOKIE;
			break;
		default:
			return null;
	}
	
	if(''==$name) { // 获取全部变量
		$data = $input;
		$filters = isset($filter) ? $filter : $default_filter;
		if($filters) {
			if(is_string($filters)){
				$filters = explode(',', $filters);
			}
			foreach($filters as $filter){
				$data = array_map_recursive($filter, $data); // 参数过滤
			}
		}
	}elseif(isset($input[$name])){ // 取值操作
		$data = $input[$name];
		$filters = isset($filter) ? $filter : $default_filter;
		if($filters){
			if(is_string($filters)){
				if(0 === strpos($filters, '/')){
					if(1 !== preg_match($filters, (string)$data)){
						// 支持正则验证
						return isset($default) ? $default : null;
					}
				}else{
					$filters = explode(',',$filters);
				}
			}elseif(is_int($filters)){
				$filters = array($filters);
			}
			
			if(is_array($filters)){
				foreach($filters as $filter){
					if(function_exists($filter)){
						// 参数过滤
						$data = is_array($data) ? array_map_recursive($filter, $data) : $filter($data);
					}else{
						$data = filter_var($data, is_int($filter) ? $filter : filter_id($filter));
						if(false === $data){
							return isset($default) ? $default : null;
						}
					}
				}
			}
		}
		
		if(!empty($type)){
			switch(strtolower($type)){
				case 'a':	// 数组
					$data = (array)$data;
					break;
				case 'd':	// 数字
					$data = (int)$data;
					break;
				case 'f':	// 浮点
					$data = (float)$data;
					break;
				case 'b':	// 布尔
					$data = (boolean)$data;
					break;
				case 's':   // 字符串
				default:
					$data = (string)$data;
			}
		}
	}else{ // 变量默认值
		$data = isset($default) ? $default : null;
	}
	is_array($data) && array_walk_recursive($data, 'zhongyi_filter');
	return $data;
}

/*
** 根据PHP各种类型变量生成唯一标识号
** @param mixed $mix 变量
** @return string
*/
function to_guid_string($mix) {
	if(is_object($mix)){
		return spl_object_hash($mix);
	}elseif(is_resource($mix)){
		$mix = get_resource_type($mix) . strval($mix);
	} else {
		$mix = serialize($mix);
	}
	return md5($mix);
}

/*
** XML编码
** @param mixed $data 数据
** @param string $root 根节点名
** @param string $item 数字索引的子节点名
** @param string $attr 根节点属性
** @param string $id   数字索引子节点key转换的属性名
** @param string $encoding 数据编码
** @return string
*/
function xml_encode($data, $root='zhongyi', $item='item', $attr='', $id='id', $encoding='utf-8') {
	if(is_array($attr)){
		$_attr = array();
		foreach ($attr as $key => $value) {
			$_attr[] = "{$key}=\"{$value}\"";
		}
		$attr = implode(' ', $_attr);
	}
	$attr   = trim($attr);
	$attr   = empty($attr) ? '' : " {$attr}";
	$xml    = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
	$xml   .= "<{$root}{$attr}>";
	$xml   .= data_to_xml($data, $item, $id);
	$xml   .= "</{$root}>";
	return $xml;
}

/*
** 数据XML编码
** @param mixed  $data 数据
** @param string $item 数字索引时的节点名称
** @param string $id   数字索引key转换为的属性名
** @return string
*/
function data_to_xml($data, $item='item', $id='id') {
	$xml = $attr = '';
	foreach ($data as $key => $val) {
		if(is_numeric($key)){
			$id && $attr = " {$id}=\"{$key}\"";
			$key  = $item;
		}
		$xml    .=  "<{$key}{$attr}>";
		$xml    .=  (is_array($val) || is_object($val)) ? data_to_xml($val, $item, $id) : $val;
		$xml    .=  "</{$key}>";
	}
	return $xml;
}

// 不区分大小写的 in_array 实现
function in_array_case($value,$array) {
	return in_array(strtolower($value), array_map('strtolower', $array));
}

function remove_xss($val) {
	// remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
	// this prevents some character re-spacing such as <java\0script>
	// note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
	$val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
	
	// straight replacements, the user should never need these since they're normal characters
	// this prevents like <IMG SRC=@avascript:alert('XSS')>
	$search = 'abcdefghijklmnopqrstuvwxyz';
	$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$search .= '1234567890!@#$%^&*()';
	$search .= '~`";:?+/={}[]-_|\'\\';
	for($i = 0; $i < strlen($search); $i++){
		// ;? matches the ;, which is optional
		// 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
		// @ @ search for the hex values
		$val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
		// @ @ 0{0,7} matches '0' zero to seven times
		$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
	}
	
	// now the only remaining whitespace attacks are \t, \n, and \r
	$ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
	$ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	$ra = array_merge($ra1, $ra2);
	
	$found = true; // keep replacing as long as the previous round replaced something
	while($found == true){
		$val_before = $val;
		for($i = 0; $i < sizeof($ra); $i++){
			$pattern = '/';
			for($j = 0; $j < strlen($ra[$i]); $j++){
				if($j > 0){
					$pattern .= '(';
					$pattern .= '(&#[xX]0{0,8}([9ab]);)';
					$pattern .= '|';
					$pattern .= '|(&#0{0,8}([9|10|13]);)';
					$pattern .= ')*';
				}
				$pattern .= $ra[$i][$j];
			}
			$pattern .= '/i';
			$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
			$val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
			
			if($val_before == $val){
				// no replacements were made, so exit the loop
				$found = false;
			}
		}
	}
	return $val;
}

// 日志记录
function log_record($uid = 0, $actions = '', $content = array()) {
	
	$data['uid'] 			= $uid; // 当前操作的管理员
	$data['actions'] 		= $actions; // 操作类型
	$data['content'] 		= $content ? json_encode($content) : ''; // 操作内容
	$data['time_create'] 	= time(); // 操作时间
	
	$Mglogs = new medoo();
	$Mglogs -> insert('mg_logs', $data);
}

// 获取客户端浏览器信息
function get_broswer() {
	$sys = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串
	if(stripos($sys, "Firefox/") > 0){
		preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
		$exp[0] = "Firefox";
		$exp[1] = $b[1];  //获取火狐浏览器的版本号
	}elseif(stripos($sys, "Maxthon") > 0){
		preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);
		$exp[0] = "傲游";
		$exp[1] = $aoyou[1];
	}elseif(stripos($sys, "MSIE") > 0){
		preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
		$exp[0] = "IE";
		$exp[1] = $ie[1];  //获取IE的版本号
	}elseif(stripos($sys, "OPR") > 0){
		preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
		$exp[0] = "Opera";
		$exp[1] = $opera[1];
	}elseif(stripos($sys, "Edge") > 0){
		//win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
		preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
		$exp[0] = "Edge";
		$exp[1] = $Edge[1];
	}elseif(stripos($sys, "Chrome") > 0){
		preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
		$exp[0] = "Chrome";
		$exp[1] = $google[1];  //获取google chrome的版本号
	}elseif(stripos($sys,'rv:')>0 && stripos($sys,'Gecko')>0){
		preg_match("/rv:([\d\.]+)/", $sys, $IE);
		$exp[0] = "IE";
		$exp[1] = $IE[1];
	}else{
		$exp[0] = "未知浏览器";
		$exp[1] = "";
	}
	return $exp[0].'('.$exp[1].')';
}

// 获取客户端操作系统信息
function get_os() {
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$os = false;
	
	if (preg_match('/win/i', $agent) && strpos($agent, '95')){
		$os = 'Windows 95';
	}else if(preg_match('/win 9x/i', $agent) && strpos($agent, '4.90')){
		$os = 'Windows ME';
	}else if(preg_match('/win/i', $agent) && preg_match('/98/i', $agent)){
		$os = 'Windows 98';
	}else if(preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent)){
		$os = 'Windows Vista';
	}else if(preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent)){
		$os = 'Windows 7';
	}else if(preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent)){
		$os = 'Windows 8';
	}else if(preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent)){
		$os = 'Windows 10';#添加win10判断
	}else if(preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent)){
		$os = 'Windows XP';
	}else if(preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent)){
		$os = 'Windows 2000';
	}else if(preg_match('/win/i', $agent) && preg_match('/nt/i', $agent)){
		$os = 'Windows NT';
	}else if(preg_match('/win/i', $agent) && preg_match('/32/i', $agent)){
		$os = 'Windows 32';
	}else if(preg_match('/linux/i', $agent)){
		$os = 'Linux';
	}else if (preg_match('/unix/i', $agent)){
		$os = 'Unix';
	}else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent)){
		$os = 'SunOS';
	}else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent)){
		$os = 'IBM OS/2';
	}else if (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent)){
		$os = 'Macintosh';
	}else if (preg_match('/PowerPC/i', $agent)){
		$os = 'PowerPC';
	}else if (preg_match('/AIX/i', $agent)){
		$os = 'AIX';
	}else if (preg_match('/HPUX/i', $agent)){
		$os = 'HPUX';
	}else if (preg_match('/NetBSD/i', $agent)){
		$os = 'NetBSD';
	}else if (preg_match('/BSD/i', $agent)){
		$os = 'BSD';
	}else if (preg_match('/OSF1/i', $agent)){
		$os = 'OSF1';
	}else if (preg_match('/IRIX/i', $agent)){
		$os = 'IRIX';
	}else if (preg_match('/FreeBSD/i', $agent)){
		$os = 'FreeBSD';
	}else if (preg_match('/teleport/i', $agent)){
		$os = 'teleport';
	}else if (preg_match('/flashget/i', $agent)){
		$os = 'flashget';
	}else if (preg_match('/webzip/i', $agent)){
		$os = 'webzip';
	}else if (preg_match('/offline/i', $agent)){
		$os = 'offline';
	}else{
		$os = '未知操作系统';
	}
	return $os;
}

// 单点登陆处理，基于 redis
function done_sso($type = '') {
	$RedisServOO = new RedisServ(0); // 使用 0 号库，session 默认使用
	$RedisServ = new RedisServ(15); // 使用 15 号库
	$session_id 	= session_id();
	$uid_key 		= 'login:uid:' . session('uid');
	$uid_exists 	= $RedisServ -> exists($uid_key); // true / false
	
	// 登陆调用
	if($type == 'login'){
		if($uid_exists){ // 登陆 uid 存在
			$sessid_info = $RedisServ -> get($uid_key);
			// 检测 session_id 是否一致
			if($session_id != $sessid_info){
				// 把旧的 session_id 清除
				$RedisServOO -> del('PHPREDIS_SESSION:' . $sessid_info);
				// 重新记录 登录 uid，并给 24 小时存活
				$RedisServ -> set($uid_key, $session_id, 86400);
			}
		}else{
			// 全新登陆，重新记录 登录 uid，并给 24 小时存活
			$RedisServ -> set($uid_key, $session_id, 86400);
		}
	}
	
	// 注销调用
	if($type == 'logout'){
		if($uid_exists){ // 登陆 uid 存在
			$RedisServ -> del($uid_key);
		}
	}
}

// 判断是否 ajax 操作
function is_ajax() {
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$request = $_SERVER['HTTP_X_REQUESTED_WITH'];
		if($request == 'XMLHttpRequest'){
			return true;
		}
	}
	return false;
}

// 判断是否 get 操作
function is_get() {
	if(isset($_SERVER['REQUEST_METHOD'])){
		$request = $_SERVER['REQUEST_METHOD'];
		if($request == 'GET'){
			return true;
		}
	}
	return false;
}

// 判断是否 post 操作
function is_post() {
	if(isset($_SERVER['REQUEST_METHOD'])){
		$request = $_SERVER['REQUEST_METHOD'];
		if($request == 'POST'){
			return true;
		}
	}
	return false;
}

// 后台顶级菜单展示
function getsubmenu($submenus) {
	$html = '';
	foreach($submenus as $menu){
		$html .= '<li>';
		$menu_name = $menu['name'];
		if(empty($menu['items'])){
			$html .= '<a href="javascript:openapp(\''.$menu['url'].'\',\''.$menu['id'].'\',\''.$menu['name'].'\',true);">';
			$html .= '<i class="fa fa-'.$menu['icon'].'"></i>';
			$html .= '<span class="menu-text"> '.$menu_name.' </span></a>';
		}else{
			$html .= '<a href="#" class="dropdown-toggle">';
			$html .= '<i class="fa fa-'.$menu['icon'].' normal"></i>';
			$html .= '<span class="menu-text normal"> '.$menu_name.' </span>';
			$html .= '<b class="arrow fa fa-angle-right normal"></b>';
			$html .= '<i class="fa fa-reply back"></i>';
			$html .= '<span class="menu-text back">返回</span></a>';
			$html .= '<ul  class="submenu"> '.getsubmenu1($menu['items']).' </ul>';
		}
		$html .= '</li>';
	}
	return $html;
}

// 后台一级菜单展示
function getsubmenu1($submenus) {
	$html = '';
	foreach($submenus as $menu){
		$html .= '<li>';
		$menu_name = $menu['name'];
		if(empty($menu['items'])){
			$html .= '<a href="javascript:openapp(\''.$menu['url'].'\',\''.$menu['id'].'\',\''.$menu['name'].'\',true);">';
			$html .= '<i class="fa fa-caret-right"></i>';
			$html .= '<span class="menu-text">'.$menu_name.'</span> </a>';
		}else{
			$html .= '<a href="#" class="dropdown-toggle">';
			$html .= '<i class="fa fa-caret-right"></i>';
			$html .= '<span class="menu-text"> '.$menu_name.' </span>';
			$html .= '<b class="arrow fa fa-angle-right"></b></a>';
			$html .= '<ul class="submenu"> '.getsubmenu2($menu['items']).' </ul>';
		}
		$html .= '</li>';
	}
	return $html;
}

// 后台二级菜单展示
function getsubmenu2($submenus) {
	$html = '';
	foreach($submenus as $menu){
		$html .= '<li>';
		$menu_name = $menu['name'];
		$html .= '<a href="javascript:openapp(\''.$menu['url'].'\',\''.$menu['id'].'\',\''.$menu['name'].'\',true);">';
		$html .= '&nbsp;<i class="fa fa-angle-double-right"></i>';
		$html .= '<span class="menu-text"> '.$menu_name.' </span> </a>';
		$html .= '</li>';
	}
	return $html;
}







