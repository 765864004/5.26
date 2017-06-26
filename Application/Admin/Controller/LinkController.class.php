<?php
namespace Admin\Controller;

class LinkController extends CommonController
{
    var $link;

    public function __construct(){
        parent::__construct();
        $this->link = M('link');
    }

    public function index(){
        $this->links = $this->link->order('sort_order')->select(); //查询数据库
        $this->display();//显示模板
    }

    //查询一个友情链接 （ajax传递id）
    public function show_edit(){
        $id = $_GET["id"]; //获取ajax传递的id $id= I("get.id");
        $link = $this->link->find($id);
        $this->ajaxReturn($link); //查询到的数据返回给ajax
    }

    //更新
    public function update(){
        $this->link->create();
        $this->link->save();
    }

    //排序 （ajax 无刷新）
    function change_sort()
    {
        $id = I("post.id");
        $this->link->where("id=$id")->setField('sort_order', I("post.sort_order"));//设置字段 提交的字段
    }

    //增加
    public function add(){
//        $this->link = D("link");
//        if(!$this->link->create()){
//            $this->error($this->link->getError());
//        }else
//            $this->link->create();
//            $id = $this->link->add();
//            $this->ajaxReturn($id);
            //$this->success("新增成功");

        $data = array();
        $this->link->create();
        if ($id = $this->link->add()) {
            $data['id'] = $id;
            $this->success($data); //传递给ajax
        }

    }

    //删除一条
    public function del_one(){
        $id = I("post.id");
        $this->link->delete($id);
        //$this->success("删除成功");
    }

    //删除选中
    public function destroy_checked(){
        $check_id = I("post.check_id"); //获取name="check_id[]"的值为数组
        //dump($check_id);
        //join(",",$check_id);
        //$this->link->delete($check_id);
        foreach($check_id as $v){
            $this->link->delete($v); //删除主键为···的数据
        }
        $this->success("删除成功");
    }

    //排序
    public function sort_order(){

        //$link = M("link");
        $id = I("post.id"); //获取id name="id[]" dump($id);
        dump($id);
        $sort_order = I("post.sort_order"); //获取序号 name="sort_order[]"

        foreach($id as $key => $i){
            //$arr = array();//声明数组$arr
            //$sort = $sort_order[$key];//把序号数组$sort_order的值分别赋值给$sort
            //$arr["sort_order"]=$sort; //把序号存入数组$arr

           // $this->link->where("id =".$i."")->save($arr); //把修改后的序号存入数据库
           // $this->link-> where("id = $i")->setField('sort_order',$sort_order["$key"]);

            $this -> link -> where("id = $i") -> setField('sort_order' , $sort_order["$key"]) ;

        }
        $this -> success("修改成功");
    }


}