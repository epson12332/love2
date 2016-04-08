<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conn = "127.0.0.1";
$database_conn = "love";
$username_conn = "root";
$password_conn = "5; u.4t; ";
$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_set_charset('utf8');
//先設定時區
date_default_timezone_set("Asia/Taipei");
//取得現在時間，用字串的形式
$tempDate = date("Ymd");
//ㄥecho $tempDate;

session_start();
?>