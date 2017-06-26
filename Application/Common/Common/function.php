<?php
//递归对栏目进行排序 无限分类
function tree(&$data,$parent_id=0,$count=1){
    static $result =array();
    foreach($data as $key => $value){
        if($value['parent_id'] ==$parent_id){
            $value['count']=$count;
            $result[]=$value;
            unset($data[$key]);
            tree($data,$value['id'],$count +1);
        }
    }
    return $result;
}

//栏目前加入空格
function indent_blank($count){
    $blank ='';
    for($i = 1;$i<$count;$i++){
        $blank.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    return $blank;
}

//dump
function dd($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

//清除缓存
//自定义函数递归的删除整个目录
function delDir($directory) {
    //判断目录是否存在，如果不存在rmdir()函数会出错
    if(file_exists($directory)) {
        //打开目录返回目录资源，并判断是否成功
        if($dir_handle=@opendir($directory)) {
            //遍历目录，读出目录中的文件或文件夹
            while($filename=readdir($dir_handle)) {
                //一定要排除两个特殊的目录
                if($filename!="." && $filename!="..") {
                    //将目录下的文件和当前目录相连
                    $subFile=$directory."/".$filename;
                    //如果是目录条件则成立
                    if(is_dir($subFile)) {
                        //递归调用自己删除子目录
                        delDir($subFile);
                    }

                    //如果是文件条件则成立
                    if(is_file($subFile)){
                        //直接删除这个文件
                        unlink($subFile);
                    }
                }
            }

            //关闭目录资源
            closedir($dir_handle);

            //删除空目录
            rmdir($directory);
        }
    }
}

//转成合适的单位
function getFileSize($bytes)
{
    //如果提供的字节数大于等于2的40次方，则条件成立
    if ($bytes >= pow(2, 40)) {
        //将字节大小转换为同等的T大小
        $return = round($bytes / pow(1024, 4), 2);

        //单位为TB
        $suffix = "TB";

        //如果提供的字节数大于等于2的30次方，则条件成立
    } elseif ($bytes >= pow(2, 30)) {
        //将字节大小转换为同等的G大小
        $return = round($bytes / pow(1024, 3), 2);

        //单位为GB
        $suffix = "GB";

        //如果提供的字节数大于等于2的20次方，则条件成立
    } elseif ($bytes >= pow(2, 20)) {
        //将字节大小转换为同等的M大小
        $return = round($bytes / pow(1024, 2), 2);

        //单位为MB
        $suffix = "MB";

        //如果提供的字节数大于等于2的10次方，则条件成立
    } elseif ($bytes >= pow(2, 10)) {

        //将字节大小转换为同等的K大小
        $return = round($bytes / pow(1024, 1), 2);

        //单位为KB
        $suffix = "KB";

        //否则提供的字节数小于2的10次方，则条件成立
    } else {
        //字节大小单位不变
        $return = $bytes;
        //单位为Byte
        $suffix = "Byte";
    }
    //返回合适的文件大小和单位
    return $return . " " . $suffix;
}

//文件类型
function getFileType($fileName)
{
    $type = "";

    if (getimagesize($fileName)) {
        $type = "图片";
        return $type;
    }

    //通过filetype()函数返回的文件类型做为选择的条件
    switch (filetype($fileName)) {
        case 'file':
            $type .= "普通文件";
            break;
        case 'dir':
            $type .= "目录文件";
            break;
        case 'block':
            $type .= "块设备文件";
            break;
        case 'char':
            $type .= "字符设备文件";
            break;
        case 'fifo':
            $type .= "命名管道文件";
            break;
        case 'link':
            $type .= "符号链接";
            break;
        case 'unknown':
            $type .= "末知类型";
            break;
        default:
            $type .= "没有检测到类型";
    }

    //返回转换后的类型
    return $type;
}

//目录大小
function dirSize($directory)
{

    //整型变量初值为0，用来累加各个文件大小从而计算目录大小
    $dir_size = 0;

    //打开目录，并判断是否能成功打开
    if ($dir_handle = @opendir($directory)) {
        //循环遍历目录下的所有文件
        while ($filename = readdir($dir_handle)) {
            //一定要排除两个特殊的目录
            if ($filename != "." && $filename != "..") {
                //将目录下的子文件和当前目录相连
                $subFile = $directory . "/" . $filename;
                //如果为目录
                if (is_dir($subFile))
                    //递归地调用自身函数，求子目录的大小
                    $dir_size += dirSize($subFile);
                //如果是文件
                if (is_file($subFile))
                    //求出文件的大小并累加
                    $dir_size += filesize($subFile);
            }
        }

        //关闭文件资源
        closedir($dir_handle);

        //返回计算后的目录大小
        return $dir_size;
    }
}

//递归删除目录
function rm_dir($directory)
{
    //判断目录是否存在，如果不存在rmdir()函数会出错
    if (file_exists($directory)) {
        //打开目录返回目录资源，并判断是否成功
        if ($dir_handle = @opendir($directory)) {
            //遍历目录，读出目录中的文件或文件夹
            while ($filename = readdir($dir_handle)) {
                //一定要排除两个特殊的目录
                if ($filename != "." && $filename != "..") {
                    //将目录下的文件和当前目录相连
                    $sub_file = $directory . "/" . $filename;
                    //如果是目录条件则成立
                    if (is_dir($sub_file)) {
                        //递归调用自己删除子目录
                        rm_dir($sub_file);
                    }

                    //如果是文件条件则成立
                    if (is_file($sub_file)) {
                        //直接删除这个文件
                        unlink($sub_file);
                    }
                }
            }

            //关闭目录资源
            closedir($dir_handle);

            //删除空目录
            rmdir($directory);
        }
    }
}


//遍历目录中的文件和文件夹
function dir_info($path)
{
    $result = [];
    $handle = opendir($path);
    while ($file = readdir($handle)) {
        $array = [];
        if ($file == "." || $file == '..') {
            continue;
        }
        $array["name"] = $file;
        $array["type"] = getFileType($path . "/" . $file);
        $array["size"] = filetype($path . "/" . $file) == 'dir' ?
            getFileSize(dirSize($path . "/" . $file)) : getFileSize(filesize($path . "/" . $file));

        $array["filectime"] = filectime($path . "/" . $file);

        $result[] = $array;
    }
    closedir($handle);
    return $result;
}