<?php
/**
 * 测试
 */
//引入要使用的类
require_once("../model/DBUtils.php");

//获取连接
$conn = DBUtils::getConnection();
$sql = "select * from news";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
//    echo  json_encode($row);
    echo "<pre>";
    var_dump($row);
    echo "</pre>";
}
