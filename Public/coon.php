<?php
//设置乱码
header("Content-Type: text/html; charset=utf8");
$link = mysql_connect("localhost", "root", "gomye", "wxseacoredb");
mysql_select_db('wxseacoredb');
mysql_query('set names utf8');
/* check connection */
if (!$link) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

/* close connection */
?>