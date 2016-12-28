<?php
/**
 * 测试文件上传
 */
//使用预定义的超全局数组 $_FILES 来处理文件上传
echo $_FILES['file']['name'];  //获取上传文件的名称
echo $_FILES['file']['type'];  //获取上传文件的类型
echo $_FILES['file']['error']; //文件上传的错误代码  正常为0
echo $_FILES['file']['tmp_name']; //文件上传的临时路径
echo $_FILES['file']['size']/1024;   //上传文件的大小   1×1024×1024 = 1M

/**
 * 计算机存储数据的最小单位是 位bit (比特)，8位是一个字节byte,
 * 1024个字节是1KB,1024KB是1MB，1024MB是1GB，1024GB是1TB
 */
//以下处理文件上传
$type = $_FILES['file']['type'];  //判断文件类型
$size = $_FILES['file']['size'];  //判断文件大小
if($type == 'image/jpeg' || $type == 'image/gif' || $type == 'image/png'  && $size < 1024*1024){
    if($_FILES['file']['error'] > 0){  //如果上传文件出错
        echo  "上传失败,错误代码".$_FILES['file']['error'];
    }else{
        //文件正常上传，做保存处理
        //使用当前时间毫秒值 做为文件名称
        $arr = explode(".",$_FILES['file']['name']);
        $suffix = $arr[count($arr) - 1];  //得到文件后缀名
        $pathName = "../ups/".time().".".$suffix;  //time()得到当前时间的毫秒值
        move_uploaded_file($_FILES['file']['tmp_name'],$pathName);
        echo "上传成功";
    }
}else{
    echo "请上传图片或者图片过大";
}

