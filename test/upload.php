<?php
/**
 * 测试文件上传
 */
//全局数组 $_FILES，可以从客户计算机向远程服务器上传文件
echo $_FILES['file']['name'];  //文件名
echo $_FILES['file']['type'];  //文件类型
echo $_FILES['file']['size']/1024; //文件大小
echo $_FILES['file']['tmp_name']; //存储在服务器的文件的临时副本的名称
echo $_FILES['file']['error'];  //由文件上传导致的错误代码

    $type = $_FILES['file']['type'];
    $size = $_FILES['file']['size'];
//只能上传 .gif 或 .jpeg .png文件，文件大小必须小于 1M
    if($type == 'image/gif'|| $type == 'image/jpeg' || $type == 'image/png' && $size < 1024 * 1024){
        if ($_FILES['file']['error'] > 0){
            echo "上传文件失败,错误代码".$_FILES['file']['error'].'<br/>';
        }else{
            //保存被上传的文件 两个参数，一个是临时文件副本 第二参数是
            $arr=explode(".", $_FILES["file"]["name"]); //explode分割字符串 相当于split
            $suffix = $arr[count($arr)-1];  //后缀
            $pathName = "".time().'.'.$suffix;
            move_uploaded_file($_FILES["file"]["tmp_name"],"../uploads/".$pathName);
            echo "上传成功";
        }
    }else{
        echo "文件类型错误";
    }

