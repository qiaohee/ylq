<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/4
 * Time: 16:06
 */
include 'public/coon.php';
$openid = $_POST["openid"];
$sql = mysql_query("select * from ylq_li where openid = '{$openid}' and state = 2");
$res = mysql_fetch_assoc($sql);
if(!$res)
{
    $sql = mysql_query("select * from ylq_quan order by rand() LIMIT 1");
}else
{
    $sql = mysql_query("select * from ylq_quan where state = 1 order by rand() LIMIT 1");
}
$ros = mysql_fetch_assoc($sql);
$sql_one = mysql_query("select * from ylq_li where openid = '{$openid}' and quan_id = {$ros['id']}");
$ros_one = mysql_fetch_assoc($sql_one);
if(!$ros_one)
{
    $ros_two = "insert into ylq_li(openid,quan_id,state) values('{$openid}','{$ros['id']}','{$ros['state']}')";
    $re = mysql_query($ros_two);
}
echo $ros['name'];
?>