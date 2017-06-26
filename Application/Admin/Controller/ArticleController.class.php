<?php
namespace Admin\Controller;

class ArticleController extends CommonController
{
    var $article;
    var $category;

    public function __construct(){
        parent::__construct();
        $this->article = D('Article');
        $this->category = D('Category');
        //$this -> categorys = $this -> category -> where("parent_id = 0") -> relation(true)-> select() ;
    }

    //显示所有文章
    public function allArticle(){


        //分页
        $count = $this->article->count();//统计满足条件的记录数
        $Page = new \Think\Page2($count,5);// 实例化分页类 传入总记录数和每页显示的记录数（分页类 page2）
        $show       = $Page->show();// 分页显示输出
        $this->assign("page",$show);
        $articles = $this->article->relation(true)->limit($Page->firstRow.','.$Page->listRows)->select();//关联每篇文章对应的类别
        //$articles = $this->article->select();
        //dump($articles);
        $this->assign("articles",$articles);

//        $count      =  $this->article->count();// 查询满足要求的总记录数
//        $Page       = new \Think\Page2($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
//        $show       = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
//        $articles =  $this->article->relation(true)->limit($Page->firstRow.','.$Page->listRows)->select();
//        $this->assign('articles',$articles);// 赋值数据集
//        $this->assign('page',$show);// 赋值分页输出

        $this->display();
    }

    //显示修改文章页面
    public function edit(){
        //使用关联查询
        //$categorys = $this->category->where("parent_id = 0")->relation(true)->select();//查询所有类别
        //$this->assign("categorys",$categorys);

        //所有类别 （递归 无限分类）使用模型去查询
        $categories = $this->category->all_categories();
        $this->assign("categories", $categories);

        $id = I("get.id"); //文章的id {{:U('article/edit', array('id'=>$article[id]))}}
        $article = $this->article->where("id = $id")->find(); //获取当前文章的信息 find获取一条记录

        $arr_enclosure=explode("|", $article["enclosure"]);//把字符串拆分为数组
        $article["arr_enclosure"] = $arr_enclosure; //将数组赋值给$article 作为一个字段
        //dump($article);
        $this->assign("article",$article);
        $this->display();
    }
    //执行修改
    public function update(){
        //获取提交的数据
        $data["id"] = I("post.id");
        $enclosure = I("post.enclosure");//获取所有的附件 name="enclosure[]" 为数组
        $data["enclosure"] = implode("|", $enclosure); //把获取到的附件数组用|分隔 数组合并成字符串
        $data["title"] = I("post.title");//标题
        $data["date"]=I("post.date");//日期
        $data["category_id"] = I("post.category_id");//类别
        $data["color"] = I("post.color");//颜色
        $data["description"] = I("post.description");//描述
        $data["abstract"] = I("post.abstract");//摘要
        $data["thumb"] = I("post.thumb");//缩略图
        $data["content"]=I("post.content");//内容

//        $data["address"]=I("post.address");//内容
//        $data["money"]=I("post.money");//价格
//        $data["size"]=I("post.size");//大小
//        $data["room"]=I("post.room");//房型
//        $data["area"]=I("post.area");//区域

        //dump($data);
        $this->article->save($data);
        $this->success("修改成功",U('allArticle')); //跳转到主页
    }

    //显示添加文章页面
    public function addArticle(){
        //使用关联查询
        //$categorys = $this->category->where("parent_id = 0")->relation(true)->select();//所有分类
        //$this->assign("categorys",$categorys);

        //所有类别 （递归 无限分类）使用模型去查询
        $categories = $this->category->all_categories();
        $this->assign("categories", $categories);

//        $id = I("get.id");
//        $category =$this->category->where("id = $id")->find(); //查询当前类别
//        $this->assign("category",$category);
        //dump($category);
        $this->display();
    }
    //添加文章
    public function store(){
        //获取提交的数据
        $enclosure = I("post.enclosure");//获取所有的附件 name="enclosure[]" 为数组
        $data["enclosure"] = implode("|", $enclosure); //把获取到的附件数组用|分隔 数组合并成字符串
        $data["title"] = I("post.title");//标题
        $data["date"]=I("post.date");//日期
        $data["category_id"] = I("post.category_id");//类别
        $data["color"] = I("post.color");//颜色
        $data["description"] = I("post.description");//描述
        $data["abstract"] = I("post.abstract");//摘要
        $data["thumb"] = I("post.thumb");//缩略图
        $data["content"]=I("post.content");//内容

        $data["address"]=I("post.address");//内容
        $data["money"]=I("post.money");//价格
        $data["size"]=I("post.size");//大小
        $data["room"]=I("post.room");//房型
        $data["area"]=I("post.area");//区域

        $this->article->add($data);
        $this->success("发表成功",U('allArticle'));
        //echo $data;
        //dump($data["content"]);
    }

    //执行删除
    public function delete(){
        if(I("post.id")){
            $id = I("post.id"); //获取所有id 获取到的为数组
            foreach($id as $v){
                $this->article->delete($v); //删除主键为···的数据
            }
        }else{
            $id = I("get.id");
            $this->article->delete($id);
        }
        $this->success("删除成功");
    }

    //栏目对应的文章列表
    public function articleList(){
        $id = I("get.id");//获取类别的id {{:U('articleList', array('id'=>$category[id]))}}
        $category = $this->category->where("id = $id")->find(); //查询当前类别
        $this->assign("category",$category);

        $articles = $this->article->where("category_id = $id")->select(); //通过类别的id查询类别所对应的所有文章
        $this->assign("articles",$articles);
        $this->display();
    }
}
