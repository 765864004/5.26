<?php
namespace Admin\Model;

use Think\Model\RelationModel;

class ArticleModel extends RelationModel
{
//    protected $_link = array(
//        'childs' => array(
//            'mapping_type' =>self::HAS_MANY,
//            'class_name' =>'Category',
//            'foreign_key' =>'parent_id',
//            'mapping_order' =>'sort_order asc', //子类排序
//        )
//    );

    //关联每篇文章的所属栏目
    protected $_link = array(
        'category'=>self::BELONGS_TO, //一篇文章只有一个栏目 只属于一个栏目
        //'comment'=>self::HAS_MANY, //一个栏目有很多文章
    );


}