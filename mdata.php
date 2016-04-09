<?php require_once('Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE member SET D_PWD=%s, D_NAME=%s, D_TEL=%s, D_ADDRESS=%s, D_EMAIL=%s WHERE D_ID=%s",
                       GetSQLValueString($_POST['PWD'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['tel'], "text"),
                       GetSQLValueString($_POST['add'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['hiddenField'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "su.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>會員資料</title>
<style type="text/css">
#apDiv1 {
	position: absolute;
	width: 120px;
	height: 53px;
	z-index: 1;
	left: 613px;
	top: 213px;
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
	left: 654px;
	top: 214px;
}
#apDiv4 {
	position: absolute;
	width: 118px;
	height: 52px;
	z-index: 4;
	left: 791px;
	top: 212px;
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
	left: 929px;
	top: 213px;
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
	left: 471px;
	top: 388px;
}
#apDiv10 {
	position: absolute;
	width: 63px;
	height: 75px;
	z-index: 10;
	left: 44px;
	top: -93px;
}
</style>
</head>

<body bgcolor="#ede4c7">

<div id="apDiv7"><img src="圖/網頁用logo.png" width="170" height="168" /></div>
<div id="apDiv8"><img src="圖/網頁標題.png" width="480" height="160" /></div>
<div id="apDiv1"><a href="s_manal.php"><img src="圖/網頁icon回首頁.png" width="120" height="54" /></a></div>
<div id="apDiv9">
  <div>

<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <label for="PWD"></label>
  <p>帳號：
  <?php echo $row_Recordset1['D_ID']; ?></p>
  <p>
    <label for="name">姓名</label>
    ：<?php echo $row_Recordset1['D_NAME']; ?></p>
  <p>
    <label for="tel">電話：</label>
    <?php echo $row_Recordset1['D_TEL']; ?></p>
  <p>
    <label for="email">email:</label>
    <?php echo $row_Recordset1['D_EMAIL']; ?></p>
  <p>
    <label for="add">地址：</label>
    <?php echo $row_Recordset1['D_ADDRESS']; ?></p>
  <p>&nbsp;</p>
</form>
</div>
<div id="apDiv10"><img src="圖/會員資料修改.png" width="350" height="69" /></div>
</div>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>