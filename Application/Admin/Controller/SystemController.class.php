<?php
namespace Admin\Controller;

class SystemController extends CommonController
{
    function config()
    {

        $path = getcwd()."/Application/Runtime";

        $side = $this->side->select(); //查询站点信息
        $this->assign('side',$side); //发送给模板
        $this->display(); //显示站点模板
    }

    //执行修改站点信息
    public function update(){
        if(IS_POST){
            $this->side->create(); //获取修改后的信息
            $this->side->where("id=1")->save();
            $this->success("修改成功" , U("Index/index")); //跳转
        }
    }

    //清除缓存 获取缓存路径
    public function cache(){
        $path = getcwd()."/Application/Runtime";
        delDir($path);
        $this->success("删除成功");
    }


}