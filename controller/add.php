<?php
require_once("../model/DBUtils.php");
header("ContentType:application/json,charset=utf-8");
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
        "' where news_id='".$newsId."'";
}else{ //如果没有id是添加
    $sql = "insert into news values(NULL,'".$newsTitle."','".$newsContent."','"
        .$newsMark."','".$postTime."','".$newsClassify."','')";
}
//echo json_encode(array($sql));
$result = mysqli_query($conn,$sql);
if($result){
    echo json_encode(array("success"=>"ok"));
}else{
    echo json_encode(array("success"=>"no"));
}