<?php
/*
** 网站设置控制器
*/

class SettingController extends AdminbaseController {
	protected $_db;
	
	// 自动优先加载
	public function init() {
		parent::init();
		
		// 初始化数据库
		$this -> _db = new medoo();
	}
	
	// 网站信息页面
	public function siteinfoAction() {
		
		$field = array('content');
		$where = array('title[]' => 'siteinfo');
		$lists = $this -> _db -> select('configs', $field, $where);
		$lists = $lists[0];
		$lists['content'] = json_decode($lists['content'], true);
		foreach($lists['content'] as $key => $val){
			$lists[$key] = $val;
		}
		unset($lists['content']);
		
		$this -> getView() -> assign('lists', $lists);
		$this -> getView() -> display('setting/siteinfo.html');
	}
	
	// 保存网站信息
	public function siteinfosaveAction() {
		$inputs = I('post.');
		
		if(!$inputs['sitename']){
			$this -> ajaxReturn(array('status'=>0,'info'=>'请输入网站名称'));
		}
		
		$sitestatus = I('post.sitestatus', 0, 'intval');
		
		$data['sitename'] 	= $inputs['sitename'];
		$data['sitehost'] 	= $inputs['sitehost'] ? $inputs['sitehost'] : '';
		$data['seokey'] 	= $inputs['seokey'] ? $inputs['seokey'] : '';
		$data['seodesc'] 	= $inputs['seodesc'] ? $inputs['seodesc'] : '';
		$data['copyright'] 	= $inputs['copyright'] ? $inputs['copyright'] : '';
		$data['siteicp'] 	= $inputs['siteicp'] ? $inputs['siteicp'] : '';
		$data['sitecyber'] 	= $inputs['sitecyber'] ? $inputs['sitecyber'] : '';
		$data['sitestatus'] = $sitestatus;
		
		// json 格式化
		$content = json_encode($data);
		
		// 保存
		$where = array('title[]' => 'siteinfo');
		$result = $this -> _db -> update('configs', array('content'=>$content), $where);
		
		$info = array('status'=>0,'info'=>'保存失败或没有数据更新');
		if($result){
			$info = array('status'=>1,'info'=>'保存成功');
		}
		$this -> ajaxReturn($info);
	}
}
