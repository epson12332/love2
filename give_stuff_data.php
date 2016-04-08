<?php require_once('Connections/conn.php'); ?>
<?php require_once('Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "小天使";
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
  $updateSQL = sprintf("UPDATE stuff SET DS_SITUATION=%s WHERE DS_ID=%s",
                       GetSQLValueString(isset($_POST['sit']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['dsid'], "int"));
  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO rewards (R_COUNT, ID, R_S_ID) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['amount'], "int"),
                       GetSQLValueString($_POST['hiddenField3'], "text"),
                       GetSQLValueString($_POST['dsid'], "int"));
  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  $insertGoTo = "成功.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
$colname_stuff = "-1";
if (isset($_POST['id'])) {
  $colname_stuff = $_POST['id'];
}
mysql_select_db($database_conn, $conn);
$query_stuff = sprintf("SELECT * FROM stuff WHERE DS_ID = %s", GetSQLValueString($colname_stuff, "int"));
$stuff = mysql_query($query_stuff, $conn) or die(mysql_error());
$row_stuff = mysql_fetch_assoc($stuff);
$colname_stuff = "-1";
if (isset($_POST['id'])) {
  $colname_stuff = $_POST['id'];
}
mysql_select_db($database_conn, $conn);
$query_stuff = sprintf("SELECT * FROM stuff WHERE DS_ID = %s", GetSQLValueString($colname_stuff, "int"));
$stuff = mysql_query($query_stuff, $conn) or die(mysql_error());
$row_stuff = mysql_fetch_assoc($stuff);
$totalRows_stuff = mysql_num_rows($stuff);
$colname_member = "-1";
if (isset($row_stuff['D_ID'])) {
  $colname_member = $row_stuff['D_ID'];
}
mysql_select_db($database_conn, $conn);
$query_member = sprintf("SELECT * FROM member WHERE D_ID = %s", GetSQLValueString($colname_member, "text"));
$member = mysql_query($query_member, $conn) or die(mysql_error());
$row_member = mysql_fetch_assoc($member);
$totalRows_member = mysql_num_rows($member);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<style type="text/css">
#apDiv1 {
	position: absolute;
	width: 120px;
	height: 53px;
	z-index: 1;
	left: 246px;
	top: 215px;
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
	left: 504px;
	top: 387px;
}
#apDiv10 {
	position: absolute;
	width: 63px;
	height: 75px;
	z-index: 10;
	left: -52px;
	top: -91px;
}
</style>
</head>

<body bgcolor="#ede4c7">

<div id="apDiv7"><img src="圖/網頁用logo.png" width="170" height="168" /></div>
<div id="apDiv8"><img src="圖/網頁標題.png" width="480" height="160" /></div>
<div id="apDiv1"><a href="s_manal.php"><img src="圖/網頁icon回首頁.png" width="120" height="54" /></a></div>
<div id="apDiv2"><img src="圖/網頁icon黃（申請會員）.png" width="120" height="54" /></div>
<div id="apDiv3"><img src="圖/網頁icon綠個人資料.png" width="120" height="54" /></div>
<div id="apDiv4"><img src="圖/網頁icon藍物資資訊.png" width="120" height="54" /></div>
<div id="apDiv5"><img src="圖/網頁icon橙登入.png" width="120" height="54" /></div>
<div id="apDiv6"><img src="圖/網頁icon(about us).png" width="120" height="54" /></div>
<div id="apDiv9">
<div>
  <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
    <p>
    <label for="ds_id">編號：</label>
    <?php echo $row_stuff['DS_ID']; ?>
    <input name="dsid" type="hidden" id="hiddenField" value="<?php echo $row_stuff['DS_ID']; ?>" />
    <input name="hiddenField3" type="hidden" id="hiddenField3" value="<?php echo $_SESSION['MM_Username']; ?>" />
  </p>
  <p>
    <label for="name">名稱：</label>
  <?php echo $row_stuff['DS_NAME']; ?></p>
  <p>數量：<?php echo $row_stuff['DS_AMOUNT']; ?>
    <input name="amount" type="hidden" id="hiddenField2" value="<?php echo $row_stuff['DS_AMOUNT']; ?>" />
  </p>
  <p>
    <input type="checkbox" name="sit" id="sit" />
    <label for="sit">確定請打勾</label>
  </p>
  <p>聯絡人：<?php echo $row_member['D_NAME']; ?></p>
  <p>電話：<?php echo $row_member['D_TEL']; ?></p>
  <p>地址：<?php echo $row_member['D_ADDRESS']; ?></p>
  <p>
    <input type="submit" name="submit" id="submit" value="送出" />
  </p>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<div>
</div>
</div>
<div id="apDiv10"><img src="圖/我要捐贈.png" width="350" height="69" /></div>
</div>
</body>
</html>
<?php
mysql_free_result($stuff);

mysql_free_result($member);
?>
