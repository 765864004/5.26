<?php
namespace Home\Controller;

use Think\Controller;

class ApiController extends Controller
{

    private $article;
    private $category;

    public function __construct(){
        parent::__construct();
        $this->article = D('Article');
        $this->category =D('Category');
    }


    public function category(){
        $categories = $this->category->select();
        dd($categories);
        dd(json_encode($categories));
        echo json_encode($categories);
    }

    public function article_list(){
        $category_id = I("get.category_id");
        $list = $this->article->where("category_id=$category_id")->select();
        echo json_encode($list);
    }

}