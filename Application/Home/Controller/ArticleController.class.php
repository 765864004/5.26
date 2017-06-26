<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends Controller {
    var $article;
    var $category;

    public function __construct(){
        parent::__construct();
        $this->article = D('Article');
        $this->category = M('Category');
    }

    public function show(){


        $search=I("post.search");
        //echo $search;
        //$condition['title']  = array('like','%'.$search.'%');
        //$condition['_logic'] = 'or'; // 关系为或

        if(isset($_POST["search"])&$search!= ""){


            $condition['title']  = array('like','%'.$search.'%');
        }

        $id =I("get.id"); //类别id


        $area = I("get.area");//获取区域

        $room = I("get.room");

        $money = I("get.money");

        $size = I("get.size");
        //dump($size);

        //dump($_GET);
        $this->assign("request", $_GET); //get到的信息发送给模板 id area 获取到再发送给模板 合并两个数组

        //把category_id 和获取到的area赋值给$condition
        //$condition["category_id"]
        $condition["category_id"] = $id;
        //$condition["area"]
        if(isset($_GET["area"])&$area!= ""){
            $condition['area'] = $_GET["area"];
        }
        //$condition["room"]
        if(isset($_GET["room"])&$room!= ""){
            $condition['room'] = $_GET["room"];
        }
        //$condition["money"]
        if(isset($_GET["money"]) & $money!=""){
            $condition['money'] = array('between',"$_GET[money], $_GET[money2]");
        }
        //$condition["size"]
        if(isset($_GET["size"]) & $size!=""){
            $condition['size'] = array('between',"$_GET[size], $_GET[size2]");
        }



        $count = $this->article->where($condition)->count();//统计满足条件的记录数


        $Page = new \Think\Page($count,16);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        $this->assign("page",$show);
        $this->assign("id",$id);


        $article = $this->article->where($condition)->order('date')->limit($Page->firstRow.','.$Page->listRows)->select(); //通过类别id查询所有文章
        //echo $this->article->getLastSql(); //最后一条sql语句
        $this->assign("article",$article);



        $this->display();
    }

    public function showone(){
        $id = I("get.id");
        $art_one=$this->article->where("id =$id")->find();

        $arr_enclosure = explode("|",$art_one["enclosure"]); //拆分为数组
        //dump($arr_enclosure);
        $art_one["arr_enclosure"] = $arr_enclosure;//把数组赋值给$art_one
        //dump($art_one);
        $this->assign("art_one",$art_one);
        $this->display();
    }

    public function add(){
        $this->display();
    }


}