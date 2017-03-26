<?php
/**
 * Athor: "KangAiJing"
 * Email:kangaijing@simpleware.com.cn
 * Date: 2017/3/23
 */
class ProductController extends BaseController{
    protected $_db;
    public function init() {
        parent::init();
        // 初始化数据库
        $this -> _db = new medoo();
    }
    //添加分类
    public function addProductAction(){
        $this -> getView() -> display('product/addProduct.html');
    }
    //编辑分类
    public function editAction(){
        $id = I('get.id',0,'intval');
        if(!$id){
            $this->ajaxReturn(['status'=>0,'info'=>'编辑失败']);
        }
        $row = $this->_db->select('product_class','*',['id'=>$id])[0];
        $this -> getView() -> assign('row',$row);
        $this -> getView() -> display('product/editProduct.html');
    }
    //分类列表
    public function productListAction(){
        $field = '*';
        $where = array();
        $lists = array();
        $lists = $this -> _db -> select('product_class', $field, $where);
        $this -> getView() -> assign('lists', $lists);
        $this -> getView() -> display('product/productList.html');
    }
    //保存分类
    public function addSaveAction(){
        $post 	= I('post.');
        //todo 还差上传的图片没有获取,前端写好上传图片功能后添加
        $id = isset($post['id']) ? $post['id'] : '';
        $class_name = $post['name'];
        $kg = $post['kg'];
        if(empty($class_name)){
            $this->ajaxReturn(['status' => 0,'info' => '请输入分类名称']);
        }
        if(empty($kg)){
            $this->ajaxReturn(['status' => 0,'info' => '请输入权重']);
        }
        //todo 权重加验证 只能为数字
//        if(!is_int($kg)){
//            $this->ajaxReturn(['status' => 0,'info' => '权重只能为数字']);
//        }
        $data = [
            'cname' => $class_name,
            'kg' => $kg,
            //todo photo字段
        ];
        if(empty($id)){
            $checkName = $this-> _db -> select('product_class','*',['cname'=>$class_name]);
            if($checkName){
                $this->ajaxReturn(['status'=>0,'info'=>'分类名称已存在']);
            }
            $result = $this -> _db -> insert('product_class',$data);
        }else{
            //编辑数据时查询当前数据和表单提交的数据是否相等,相等不更新数据库,不相等更新数据库
            $row = $this-> _db -> select('product_class','*',['id'=>$id])[0];
            if($row['cname'] === $class_name && $row['kg'] === $kg){
                $result = true;
            }else{
                $result = $this -> _db -> update('product_class',$data,['id'=>$id]);
            }
        }
        if($result){
            $this->ajaxReturn(['status' => 1,'info' => '保存成功']);
        }else{
            $this->ajaxReturn(['status' => 0,'info' => '保存失败']);
        }
    }
    public function indexAction(){
        $this -> getView() -> display('product/pic_cut.html');
    }
    //删除分类暂不使用
/*    public function deleteProductAction(){
        $id = I('get.id',0,'intval');
        $delete = $this->_db->delete('product_class',['id'=>$id]);
        if($delete){
            $this->ajaxReturn(['status' => 0,'info' => '删除成功']);
        }else{
            $this->ajaxReturn(['status' => 0,'info' => '删除失败']);
        }
    }*/
}