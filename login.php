<?php
include "public/coon.php";
include 'public/Wechat.class.php';
session_start();
$wc = new Wechat();
if(!isset($_SESSION['info']))
{
    $uri = "http://wx.seacore.com.cn/wxzsmz1/ylq/index.php";
    $state = 123;
    $ss = $wc->get_authorize_url($uri,$state);
    header("Location:{$ss}");
}else {
    header("http://wx.seacore.com.cn/wxzsmz1/ylq/index.php");
}