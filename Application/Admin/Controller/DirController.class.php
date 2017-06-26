<?php
namespace Admin\Controller;

use Think\Controller;

//前端文件管理
class DirController extends CommonController
{
    var $path;

    public function __construct()
    {
        //URL_MODEL' => 0,就使用index.php?m=Home&c=Index&a=index访问
        //URL_MODEL' => 1,就使用index.php/Home/Index/index访问
        C("URL_MODEL", 0);
        parent::__construct();
        $this->path = isset($_GET['path']) ? $_GET["path"] : getcwd() . '/Public';
        $this->assign('path', $this->path);
        //dump($this->path);
    }

    public function index()
    {
        $files =dir_info($this->path);//遍历目录中的文件和文件夹dir_info
        $this->assign('files',$files);
        //dump($files);
        $this->display();
    }

    //显示修改页面
    public function edit(){
        echo "$this->path";//E:\wamp\www\tpcms3/Public/bootstrap5555.css
        $name = basename($this->path);//显示带有文件扩展名的文件名 （只获取文件名和扩展名）
        $content =file_get_contents($this->path);//将文件的内容读入到一个字符串中(根据文件地址读取文件内容)
        $this->assign("name",$name); //发送文件名
        $this->assign("content",$content); //发送文件内容

        $this->display();
    }
    //执行修改
    public function update(){
        $name = $_POST['name']; //获取文件名
        $content =$_POST['content']; //获取文件内容

        $path =dirname($this->path); //去掉文件名和扩展名（只要路径）

        //$this->path-当前文件的路径路径，$path-去掉文件名的路径，$name-获取到的修改后的文件名
        rename($this->path, $path . '/' . $name);//重命名文件名 rename(原文件名，修改后的文件名)
        //$path . '/' . $name-修改后的路径，$content-修改后内容，
        file_put_contents($path . '/' . $name, $content);//将内容放入文件中
        $this->success('修改成功',U('edit',array('path'=>$path . '/' . $name)));

    }

    //显示添加页面
    public function add(){
        $this->display();
    }
    //执行添加
    public function store(){
        $name=$_POST['name'];
        $content=$_POST['content'];
        file_put_contents($this->path . '/' .$name, $content);//将文件存入该路径
        $this->success('修改成功',U('index',array('path'=>$this->path)));//跳转到index 路径为public
    }

    //执行删除
    public function destroy(){
        unlink($this->path);
        $this->success('删除成功');
    }

    //显示图片页面
    public function show(){
        // ../../../../Public/xCms/img/background.jpg  __PUBLIC__/xCms/img/background.jpg
        $path = I("get.path");//获取路径
        //$this->assign("path",$path);
        //echo "$path";
        $path2 = explode("/", $path,2);
        //dump($path2);

//        $path3 = explode("Public",$path);
//        dump($path3);
//        $src = "Public" . $path3[1];
//        $this->assign("src",$src);

//        $content =file_get_contents($path);//获取文件内容
//        dump($content);
//
//        $path1 = basename($path);//获取文件名和扩展名
//        dump($path1);
//
//        $path2 =dirname($path);//去掉文件名和扩展名
//        dump($path2);
//
//        $path3 = pathinfo($path);//数组显示文件信息
//        dump($path3);

        $this->assign("path2",$path2);

        $this->display();
    }

    //文件下载
    public function download(){

        //$path = I("get.path");//获取路径
        //$name = basename($this->path);//只要文件名和扩展名
        //指定文件名
        //$filename=$name;

        //指定下载文件类型
        //header('Content-Type: image/gif');

        header('Content-Disposition: attachment; filename="'.$this->path.'"');   //指定下载文件的描述

        //指定下载文件的大小
        header('Content-Length: '.filesize($this->path));

        //将文件内容读取出来并直接输出，以便下载
        readfile($this->path);

//        $name = basename($this->path);//只要文件名和扩展名
//        $filename=$name;
//        header("Content-Type: application/force-download");
//        header("Content-Transfer-Encoding: binary");
//        header('Content-Type: application/zip');
//        header('Content-Disposition: attachment; filename='.$filename);
//        readfile($filename);
    }

    //文件上传
    public function upload(){

        if ($_FILES['file']['error'] > 0) { //错误代码  0表示没有错误
            echo '上传错误: ';
            switch ($_FILES['file']['error']) {
                case 1:
                    echo '上传文件大小超出了PHP配置文件中的约定值：upload_max_filesize';
                    break;
                case 2:
                    echo '上传文件大小超出了表单中的约定值：MAX_FILE_SIZE';
                    break;
                case 3:
                    echo '文件只被部分上载';
                    break;
                case 4:
                    echo '没有上传任何文件';
                    break;
            }
            //如果$_FILES['myfile']['error']大于0都是有错误，输出错误信息并退出程序
            exit;
        }

        //安全的判断图片的方法（只上传图片）
//        if (!getimagesize($_FILES['file']['tmp_name'])) { //tmp_name-存储在服务器的文件的临时副本的名称
//            echo '问题: 只能上传图片。';
//            exit;
//        }

        //截取文件后缀名
        $extension = strrchr($_FILES['file']['name'], '.'); //后缀名
        //$name = $_FILES['file']['name']; //文件名+后缀名

        //定义上传后的位置和新文件名
        $dir = 'uploads/' . date('Y_m_d', time()); //文件的目录 （upload/时间）
        if (!is_dir($dir)) {
            //递归建立目录
            mkdir($dir, 0777, true);
        }

        $upfile = $dir . '/' . time() . '_' . rand(100000, 999999) . $extension; //上传文件的目录和文件名
        //$upfile = $dir . '/' .$name; //上传文件的目录和文件名

        //判断是否为上传文件
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            //从移动文件
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $upfile)) {
                echo '问题: 不能将文件移动到指定目录。';
                exit;
            }
        } else {
            echo '问题: 上传文件不是一个合法文件: ';
            echo $_FILES['file']['name'];
            exit;
        }

        //如果文件上传成功则输出
        echo '文件' . $upfile . '上传成功,大小为' . $_FILES['file']['size'] . '！<br>';

        $this->success('上传成功');
    }

}