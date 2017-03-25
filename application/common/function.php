<?php
/*
** 业务公共函数库
*/


/*
** 判断是否为手机访问
** @return  boolean
*/
function is_mobile() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$mobile_agents = Array("240x320", "acer", "acoon", "acs-", "abacho", "ahong", "airness", "alcatel", "amoi", "android", "anywhereyougo.com", "applewebkit/525", "applewebkit/532", "asus", "audio", "au-mic", "avantogo", "becker", "benq", "bilbo", "bird", "blackberry", "blazer", "bleu", "cdm-", "compal", "coolpad", "danger", "dbtel", "dopod", "elaine", "eric", "etouch", "fly ", "fly_", "fly-", "go.web", "goodaccess", "gradiente", "grundig", "haier", "hedy", "hitachi", "htc", "huawei", "hutchison", "inno", "ipad", "ipaq", "ipod", "jbrowser", "kddi", "kgt", "kwc", "lenovo", "lg ", "lg2", "lg3", "lg4", "lg5", "lg7", "lg8", "lg9", "lg-", "lge-", "lge9", "longcos", "maemo", "mercator", "meridian", "micromax", "midp", "mini", "mitsu", "mmm", "mmp", "mobi", "mot-", "moto", "nec-", "netfront", "newgen", "nexian", "nf-browser", "nintendo", "nitro", "nokia", "nook", "novarra", "obigo", "palm", "panasonic", "pantech", "philips", "phone", "pg-", "playstation", "pocket", "pt-", "qc-", "qtek", "rover", "sagem", "sama", "samu", "sanyo", "samsung", "sch-", "scooter", "sec-", "sendo", "sgh-", "sharp", "siemens", "sie-", "softbank", "sony", "spice", "sprint", "spv", "symbian", "tablet", "talkabout", "tcl-", "teleca", "telit", "tianyu", "tim-", "toshiba", "tsm", "up.browser", "utec", "utstar", "verykool", "virgin", "vk-", "voda", "voxtel", "vx", "wap", "wellco", "wig browser", "wii", "windows ce", "wireless", "xda", "xde", "zte");
	$is_mobile = false;
	foreach($mobile_agents as $device){
		if(stristr($user_agent, $device)){
			$is_mobile = true;
			break;
		}
	}
	return $is_mobile;
}

/*
** 判断是否为微信访问
** @return boolean
*/
function is_weixin() {
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){
		return true;
	}
	return false;
}

// 生成惟一订单号
function create_order_sn() {
	return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

// 组合输出分类树状列表图标(缩进)
function get_tree_icons($path) {
	$paths = explode('-', $path);
	$length = count($paths);
	$icons = '';
	// 顶级
	if($length == 2){
		$icons = '';
	}
	if($length > 2){
		$iconsNum = $length * ($length - 1);
		for($i = 0; $i < $iconsNum; $i++){
			$icons .= '&nbsp;';
		}
		$icons = $icons . '|---';
	}
	
	return $icons;
}

// 获取后台菜单名称
function get_menu_name($id) {
	$Medoo = new medoo();
	$lists = $Medoo -> select('mg_menu', array('name'), array('id[=]'=>$id)); // 二维数组
	return $lists[0]['name'];
}

// 获取地区名称
function get_area_name($id) {
	$Medoo = new medoo();
	$lists = $Medoo -> select('district', array('name'), array('id[=]'=>$id)); // 二维数组
	return $lists[0]['name'];
}

// 获取中医馆名称
function get_hospital_name($id) {
	$Medoo = new medoo();
	$lists = $Medoo -> select('hospital', array('name'), array('id[=]'=>$id)); // 二维数组
	return $lists[0]['name'];
}


