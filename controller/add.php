<?php
require_once("../model/DBUtils.php");
header("ContentType:application/json,charset=utf-8");
//处理文件上传
$fileName = $_FILES['file']['name'];  //原文件名
$fileSize = $_FILES['file']['size'];   //文件大小
$type = strstr($fileName,".");  //strstr 返回第一个参数中 从第二个参数开始到结尾的字符串

if($type == ".jpg" || $type == ".png" || $type == ".gif" && $fileSize < 1024*1024 ){
    $pathName = "../uploads/".date("YmdHis",time()).rand(100,999).$type;  //设置图片保存路径
    move_uploaded_file($_FILES["file"]["tmp_name"],$pathName);  //move_uploaded_file 将上传文件的临时路径 保存到指定路径
//    echo json_encode(array("上传成功"));
}else{
//    echo json_encode(array("文件类型错误","文件大小超出1M"));
}

$newsId = $_POST['newsId'];
$newsTitle = $_POST['newsTitle'];
$newsContent = $_POST['newsContent'];
$newsMark = $_POST['newsMark'];
$postTime =  date('Y-m-d H:i:s',time());  //当期时间
$newsClassify = $_POST['newsClassify'];

$conn = DBUtils::getConnection();

if($newsId){  //如果有id 说明是修改
    $sql = "update news set news_title ='".$newsTitle.
        "',news_content = '".$newsContent.
        "',news_mark = '".$newsMark.
        "',post_time='".$postTime.
        "',news_classification='".$newsClassify.
        "',thumb_path='".$pathName.
        "' where news_id='".$newsId."'";
}else{ //如果没有id是添加
    $sql = "insert into news values(NULL,'".$newsTitle."','".$newsContent."','"
        .$newsMark."','".$postTime."','".$newsClassify."','".$pathName."')";
}
//echo json_encode(array($sql));
$result = mysqli_query($conn,$sql);
if($result){
    echo json_encode(array("success"=>"ok"));
}else{
    echo json_encode(array("success"=>"no"));
}