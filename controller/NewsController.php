<?php
/**
 *操作新闻表的控制器
 */

require_once("../model/DBUtils.php");
header("ContentType:application/json,charset=utf-8");
//$_GET $_POST 预定义的超全局数组  用来接受页面提交的数据
$do = $_GET["do"];

switch ($do){
    case "type":
        getNewsByType();
        break;
    case "list":
        listNews();
        break;
    case "add":
        add();
        break;
    case "add2":
        add2();
        break;
    case "del":
        del();
        break;
    case "edit":
        edit();
        break;
}
//新闻列表
function listNews(){
    $conn = DBUtils::getConnection();
    $sql = "select * from news order by news_id desc";
    $result = mysqli_query($conn,$sql);
    $arr = array();
    while($row = mysqli_fetch_assoc($result)) {
        array_push($arr,json_encode($row));
    }
    echo json_encode($arr);

}

//获取分类下的所有新闻
function getNewsByType(){
    $type = "'".$_GET['type']."'";
    //连接数据库
    $conn = DBUtils::getConnection();
    $sql = "select * from news where news_classification = $type";
//    echo json_encode($sql);
    $result = mysqli_query($conn,$sql);
    $arr = array();
    while($row = mysqli_fetch_assoc($result)){
      array_push($arr,$row);
    }
    echo json_encode($arr);
}


function add(){
    //处理文件上传
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
            $pathName = "../uploads/".time().'.'.$suffix;
            move_uploaded_file($_FILES["file"]["tmp_name"],$pathName);
            echo "上传成功";
        }
    }else{
        echo "文件类型错误";
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

    $result = mysqli_query($conn,$sql);
    if($result){
        echo "操作成功";
    }else{
        echo "操作失败";
    }
    header("Location:http://localhost/mbdnews/tpl/admin.html");
}
//删除
function del(){
    $newsId = $_GET['newsId'];
    $conn = DBUtils::getConnection();
    $sql = "delete from news where news_id=".$newsId;
    $res = mysqli_query($conn,$sql);
    if($res){
        echo json_encode(array("删除成功"=>"ok"));
    }else{
        echo json_encode(array("删除失败"=>"no"));
    }
}

function edit(){
    $newsId = $_GET['newsId'];
    //通过id值 找到这条新闻数据的所有字段
    $row = findById($newsId);
    echo json_encode($row);
}

function findById($id){
    $connect = DBUtils::getConnection();
    $sql = "select * from news where news_id = $id";
    $result = mysqli_query($connect,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}


//添加新闻 不带图片上传
function add2(){
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
            .$newsMark."','".$postTime."','".$newsClassify."')";
    }
    $result = mysqli_query($conn,$sql);
    if($result){
        echo json_encode(array("success"=>"ok"));
    }else{
        echo json_encode(array("success"=>"no"));
    }
}