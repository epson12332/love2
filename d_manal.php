<?php require_once('Connections/conn.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  $_SESSION['char']= $row_Recordset1['D_CHAR'];;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "小主人";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_conn, $conn);
$query_Recordset1 = sprintf("SELECT * FROM member WHERE D_ID = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php  if ($row_Recordset1['D_CHAR']='S'){
	$cn='小天使';}
	else if ($row_Recordset1['D_CHAR']='D'){$cn='小主人';}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>操作目錄</title>
<style type="text/css">
#apDiv1 {
	position: absolute;
	width: 120px;
	height: 53px;
	z-index: 1;
	left: 374px;
	top: 220px;
}
#apDiv2 {
	position: absolute;
	width: 121px;
	height: 51px;
	z-index: 2;
	left: 517px;
	top: 214px;
}
#apDiv3 {
	position: absolute;
	width: 119px;
	height: 54px;
	z-index: 3;
	left: 535px;
	top: 219px;
}
#apDiv4 {
	position: absolute;
	width: 118px;
	height: 52px;
	z-index: 4;
	left: 651px;
	top: 217px;
}
#apDiv5 {
	position: absolute;
	width: 112px;
	height: 42px;
	z-index: 5;
	left: 379px;
	top: 215px;
}
#apDiv6 {
	position: absolute;
	width: 121px;
	height: 53px;
	z-index: 6;
	left: 701px;
	top: 222px;
}
#apDiv7 {
	position: absolute;
	width: 216px;
	height: 170px;
	z-index: 7;
	left: 294px;
	top: 28px;
}
#apDiv8 {
	position: absolute;
	width: 200px;
	height: 115px;
	z-index: 8;
	left: 536px;
	top: 33px;
}
#apDiv9 {
	position: absolute;
	width: 437px;
	height: 157px;
	z-index: 9;
	left: 398px;
	top: 387px;
}
#apDiv10 {
	position: absolute;
	width: 63px;
	height: 75px;
	z-index: 10;
	left: 41px;
	top: -97px;
}
</style>
</head>

<body bgcolor="#ede4c7">

<div id="apDiv7"><img src="圖/網頁用logo.png" width="170" height="168" /></div>
<div id="apDiv8"><img src="圖/網頁標題.png" width="480" height="160" /></div>
<div id="apDiv1"><a href="s_manal.php"><img src="圖/網頁icon回首頁.png" width="120" height="54" /></a></div>
<div id="apDiv3"><a href="mdata.php"><img src="圖/網頁icon綠個人資料.png" width="120" height="54" /></a></div>
<div id="apDiv6"><a href="aboutus.php"><img src="圖/網頁icon(about us).png" width="120" height="54" /></a></div>
<div id="apDiv9">
<div><p>hi,小主人
<?php   
echo $row_Recordset1['D_NAME']; ?></p>
  <p><a href="new_stuff.php">我需要物資</a>  </p>
  <p><a href="stuff_supplied.php">小天使提供的物資</a></p>
<p><a href="stuffdata.php">我所需物資列表</a></p>
<p><a href="<?php echo $logoutAction ?>">登出</a></p>
</div>
<div id="apDiv10"><img src="圖/歡迎光臨.png" width="350" height="69" /></div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>