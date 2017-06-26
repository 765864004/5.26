<?php
namespace Admin\Controller;

//文件管理（上传文件管理）
class FileController extends CommonController
{
    var $category;
    var $article;

    public function __construct()
    {
        parent::__construct();
        $this->category = D('Category');
        $this->article = D('Article');
    }

    public function index()
    {
        $this->display();
    }

}