<?php
require_once("../model/DBUtils.php");
header("ContentType:application/json,charset=utf-8");
$newsId = $_GET['newsId'];

//通过id值 找到这条新闻数据的所有字段
$connect = DBUtils::getConnection();
$sql = "select * from news where news_id = $newsId";
//echo json_encode(array($sql));
$result = mysqli_query($connect,$sql);
$row = mysqli_fetch_assoc($result);
echo json_encode($row);

