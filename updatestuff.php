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
  $updateSQL = sprintf("UPDATE stuff SET DS_NAME=%s, DS_AMOUNT=%s, DS_CLASS=%s, DS_SITUATION=%s WHERE DS_ID=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['amount'], "text"),
                       GetSQLValueString($_POST['select'], "text"),
                       GetSQLValueString(isset($_POST['situ']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['hiddenField'], "int"));

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
$col2_Recordset1 = "-1";
if (isset($_POST['id'])) {
  $col2_Recordset1 = $_POST['id'];


}
mysql_select_db($database_conn, $conn);
$query_Recordset1 = sprintf("SELECT * FROM stuff WHERE D_ID = %s  and DS_ID = %s ", GetSQLValueString($colname_Recordset1, "text"),GetSQLValueString($col2_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>更新物資資訊</title>
<style type="text/css">
#apDiv1 {
	position: absolute;
	width: 120px;
	height: 53px;
	z-index: 1;
	left: 561px;
	top: 222px;
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
	height: 352px;
	z-index: 9;
	left: 403px;
	top: 382px;
}
#apDiv10 {
	position: absolute;
	width: 63px;
	height: 75px;
	z-index: 10;
	left: 59px;
	top: -89px;
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
  <p>編號： <?php echo $row_Recordset1['DS_ID']; ?>
    <input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_Recordset1['DS_ID']; ?>" />
  </p>
  <p>
    <label for="name"><label for="name">名稱</label>
  ：
  <input name="name" type="text" id="name" value="<?php echo $row_Recordset1['DS_NAME']; ?>" />
  </p>
  <p>類別：
    <select name="select" id="select" title="<?php echo $row_Recordset1['DS_CLASS']; ?>">
    
  <option value="日用品">日用品</option>
  <option value="食物">食物</option>
  <option value="營養品">營養品</option>
  <option value="文教">文教</option>
  <option value="醫療">醫療</option>
  <option value="其他">其他</option>
    </select>
    
  </p>
  <p>
    <label for="amount">數量：</label>
    <input name="amount" type="text" id="amount" value="<?php echo $row_Recordset1['DS_AMOUNT']; ?>" />
  </p>
  <p>
    <label for="situ">完成：</label>
    <input type="checkbox" name="situ" id="situ" />
  </p>
  <p>
    <input type="submit" name="submit" id="submit" value="送出" />
  </p>
  </p>
  <p>&nbsp;</p>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
</div>
<div id="apDiv10"><img src="圖/更新資訊.png" width="350" height="69" /></div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
