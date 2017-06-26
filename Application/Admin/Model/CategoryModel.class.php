<?php
namespace Admin\Model;

use Think\Model;

class CategoryModel extends Model //关联模型
{
//    protected $_link = array(
//        'childs' => array( //childs子类名
//            'mapping_type' =>self::HAS_MANY,//一个父类有很多子类
//            'class_name' =>'Category', //数据库名
//            'foreign_key' =>'parent_id', //关联的字段 parent_id=0的有很多个 一个父类有很多子类
//            'mapping_order' =>'sort_order asc', //子类排序 根据sort_order字段排序
//        )
//    );
    function all_categories(){
        if(!F('admin_category_categories')){//如果缓存不存在
            $categories =$this->order('`parent_id` asc,`sort_order` asc,id asc')->select();//根据字段排序
            F('admin_category_categories',tree($categories));//设置缓存 将查询到的数据存入缓存 tree-递归无限分类方法 tree($categories)-要存入的数据
        }
        return F('admin_category_categories'); //获取缓存 缓存为所有分类
    }
}