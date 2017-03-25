<?php
/*
** 系统日志
*/

class Log {
	// 日志级别 从上到下，由低到高
	const EMERG     = 'EMERG'; 	// 严重错误: 导致系统崩溃无法使用
	const ALERT     = 'ALERT'; 	// 警戒性错误: 必须被立即修改的错误
	const CRIT      = 'CRIT'; 	// 临界值错误: 超过临界值的错误，例如一天24小时，而输入的是25小时这样
	const ERR       = 'ERR'; 	// 一般错误: 一般性错误
	const WARN      = 'WARN'; 	// 警告性错误: 需要发出警告的错误
	const NOTICE    = 'NOTIC'; 	// 通知: 程序可以运行但是还不够完美的错误
	const INFO      = 'INFO'; 	// 信息: 程序输出信息
	const DEBUG     = 'DEBUG'; 	// 调试: 调试信息
	const SQL       = 'SQL'; 	// SQL：SQL语句 注意只在调试模式开启时有效
	
	// 日志路径信息
	static protected $logpath   =   null;
	
	// 初始化日志路径
	public function __construct() {
		$config = Yaf_Application::app()->getConfig()->get('syslog');
		self::$logpath = $config['path'];
	}
	
	/*
	** 日志直接写入
	** @static
	** @access public
	** @param string $message 日志信息
	** @param string $level  日志级别
	** @param integer $type 日志记录方式
	** @param string $destination  写入目标
	** @return void
	*/
	static function write($message, $destination='') {
		$config = Yaf_Application::app()->getConfig()->get('syslog');
		self::$logpath = $config['path'];
		$now = date('c');
		
		if(empty($destination)){
			$destination = self::$logpath.date('y_m_d').'.log';
		}
		
		// 自动创建日志目录
		$log_dir = dirname($destination);
		if(! is_dir($log_dir)){
			mkdir($log_dir, 0755, true);
		}
		
		// 检测日志文件大小，超过配置大小则备份日志文件重新生成
		if(is_file($destination) && floor(2097152) <= filesize($destination)){
			rename($destination,dirname($destination).'/'.time().'-'.basename($destination));
		}
		error_log("[{$now}] ".$_SERVER['REMOTE_ADDR'].' '.$_SERVER['REQUEST_URI']."\r\n{$message}\r\n", 3,$destination);
	}
}
