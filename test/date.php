<?php
/**
 * Created by PhpStorm.
 * User: water
 * Date: 2016/12/21
 * Time: 14:45
 */
//当前时间的毫秒值 time()

$time = time();
//echo $time;
$date = date('Y-m-d H:i:s',$time);  //当前时间
echo $date;
var_dump($date);