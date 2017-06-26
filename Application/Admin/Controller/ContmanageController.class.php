<?php
namespace Admin\Controller;

class ContmanageController extends CommonController{
        var $category;
        var $article;

    public function __construct(){
        parent::__construct();
        $this->category = D('Category');
        $this->article = D('Article');
        //$this -> categorys = $this -> category -> where("parent_id = 0") -> relation(true)-> select() ;
        if(!F('admin_category_categories')){//如果缓存不存在
            $categories =$this->category->order('`parent_id` asc,`sort_order` asc,id asc')->select();//根据字段排序
            F('admin_category_categories',tree($categories));//设置缓存
        }
        //dump(F('admin_category_categories'));
    }

    public function index(){
        //1.
//        $categorys = $this->category->where("parent_id = 0")->order('sort_order')->select(); //查询所有父类
//        foreach($categorys as &$v){ //将子类赋值给父类
//            $v["childs"] = $this->category->where("parent_id = $v[id]")->order('sort_order')->select();
//        }
//        //dd($categorys);

        //2.使用关联 查询所有父类和子类
        //查询所有的父类和所关联的子类
        //$categorys = $this->category->where("parent_id=0")->order('sort_order')->relation(true)->select();

        //3.使用无限分类 查询所有父类和子类
        //所有类别 （递归 无限分类）使用模型去查询
        $categories = $this->category->all_categories();
        $this->assign("categories", $categories);

        //使用构造函数查询
        //$this->assign("categories", F('admin_category_categories')); //获取缓存数据 发送给模板
        //dump($categorys);

        //4.使用无限极分类 （不适用缓存）
//        $cates = $this->category->select();
//        dd(tree($cates));

        $this->display();
    }

    //显示新增页面
    public function add(){
        //查询所有类别 （关联类别）
        //$categorys = $this->category->where("parent_id=0")->order('sort_order')->relation(true)->select(); //关联子类
        //所有类别 （递归 无限分类）
        $categories = $this->category->all_categories();
        $this->assign("categories",$categories);

        //查询当前的类别
        $id = I("get.id"); //获取id 从修改链接中获取id
        //$category = $this->category->relation(true)->find($id); //通过id查找单条记录
        $category = $this->category->find($id);
        dump($category);
        $this->assign("category",$category);

        $this->display();
    }
    //执行新增
    public function do_add_category(){
        //dd($_POST) ;
        //exit ;

        F('admin_category_categories',NULL);
        $this->category->create();
        $this->category->add();
        $this->success("新增成功",U('index'));
    }
    //添加内容
    public function add_cont(){
        $this->category->create();
        $this->category->add();
        $this->success("新增成功",U('index'));
    }

    //显示修改页面
    public function edit(){
        $id = I("get.id"); //获取id 从修改链接中获取id
        //所有类别 （关联类别）
        //$categorys = $this->category->where("parent_id=0")->order('sort_order')->relation(true)->select();
        //所有类别 （递归 无限分类）
        $categories = $this->category->all_categories();
        $this->assign("categories",$categories);

        //$category = $this->category->relation(true)->find($id); //通过id查找单条记录
        $category = $this->category->find($id);
        $this->assign("category",$category);

        $this->display();
    }
    //执行修改
    public function update(){
        if(IS_POST){
            $this->category->create(); //获取修改后的信息
            $this->category->save();
            $this->success("修改成功",U('index')); //跳转到主页
        }
    }

    //执行删除
    public function delete(){
        F('admin_category_categories',NULL);
        $id = I("get.id");
        $this->category->delete($id);
        $this->success("删除成功", U('index'));
    }

    //排序
    public function sort_order(){
        $id = I("post.id"); //获取所有的父类的id
        //dump($id);
        $sort_order = I("post.sort_order"); //获取所有父类的序号

        foreach($id as $key => $val){
            $this->category->where("id = $val")->setField("sort_order",$sort_order["$key"]);
        }

        $this->success("排序成功");
    }

}
