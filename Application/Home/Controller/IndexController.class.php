<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    var $article;
    var $category;

    public function __construct(){
        parent::__construct();
        $this->article = D('Article');
        $this->category = D('Category');
    }

    public function index(){
        $categorys = $this->category->select();//查询所有的类别
        //dump($categorys);
        foreach($categorys as $key=>$val){ //类别样式
            $arr_class = array("hp_xinfang","hp_chuzu","hp_xiezilou","hp_ershoufang","hp_rizufang","hp_shangpuwang","hp_changfang","hp_qiuzu","hp_hezu");
            $categorys["$key"]["arr_class"] = $arr_class["$key"];
        }
        $this->assign("categorys",$categorys);
        //所有的租房信息 包括出租 求租 合租
        $articles = $this->article->where("category_id =2 or category_id=5 or category_id=8 or category_id=9")->select();
        $this->assign("articles",$articles);

        //所有新房
        $xfs = $this->article->where("category_id =1")->order('id asc')->select();
        $this->assign("xfs",$xfs);
        //dump($xfs);

        //最新一条租房
        $new = $this->article->where("category_id =2 or category_id=5 or category_id=8 or category_id=9")->order('date desc')->limit(1)->find();//根据时间的降序排序 取第一条
        $this->assign("new",$new);

        //最新一条新房
        $newxf = $this->article->where("category_id =1")->order('date desc')->limit(1)->find();//根据时间的降序排序 取第一条
        $this->assign("newxf",$newxf);
        //dump($newxf);
        $this->display();
    }

    public function choice(){
        $this->display();
    }


}