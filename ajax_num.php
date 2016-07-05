<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/4
 * Time: 16:06
 */
include 'public/coon.php';
$openid = $_POST["openid"];
$time = time();
$time = date("Y-m-d", $time);
$temp_time = strtotime($time);
$db = mysql_query("select * from ylq where openid = '{$openid}' and time = {$temp_time}");
$res = mysql_fetch_assoc($db);
if(!$res)
{
    $db = mysql_query("update ylq set num = 0,time='{$temp_time}' where openid = '{$openid}'");
}
if($res['num'] < 5)
{
    $temp_num = $res['num'] + 1;
    $db = mysql_query("update ylq set num ={$temp_num} where openid = '{$openid}'");
    echo 1;
}else
{
    echo 2;
}
?>