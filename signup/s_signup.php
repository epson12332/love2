<?php require_once('../Connections/conn.php'); ?>
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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="error.php";
  $loginUsername = $_POST['ID'];
  $LoginRS__query = sprintf("SELECT D_ID FROM member WHERE D_ID=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_conn, $conn);
  $LoginRS=mysql_query($LoginRS__query, $conn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO member (D_ID, D_PWD, D_NAME, D_TEL, D_ADDRESS, D_EMAIL, D_CHAR) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID'], "text"),
                       GetSQLValueString($_POST['PWD'], "text"),
                       GetSQLValueString($_POST['neme'], "text"),
                       GetSQLValueString($_POST['TEL'], "text"),
                       GetSQLValueString($_POST['addr'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['hiddenField'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "../su.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>小天使註冊</title>
<style type="text/css">
#apDiv1 {
	position: absolute;
	width: 120px;
	height: 53px;
	z-index: 1;
	left: 594px;
	top: 223px;
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
	left: 525px;
	top: 414px;
}
#apDiv10 {
	position: absolute;
	width: 63px;
	height: 75px;
	z-index: 10;
	left: -29px;
	top: -103px;
}
</style>
</head>

<body bgcolor="#ede4c7">

<div id="apDiv7"><img src="../圖/網頁用logo.png" width="170" height="168" /></div>
<div id="apDiv8"><img src="../圖/網頁標題.png" width="480" height="160" /></div>
<div id="apDiv1"><a href="../s_manal.php"><img src="../圖/網頁icon回首頁.png" width="120" height="54" /></a></div>

<div id="apDiv9">
<div>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
      <p>
        <label for="ID">帳號</label>
        <input type="text" name="ID" id="ID" />
      </p>
      <p>
        <label for="PWD">密碼</label>
        <input type="password" name="PWD" id="PWD" tabindex="密" />
      </p>
      <p>
        <label for="neme">姓名</label>
        <input type="text" name="neme" id="neme" />
      </p>
      <p>
        <label for="TEL">電話</label>
        <input type="text" name="TEL" id="TEL" />
      </p>
      <p>email
        <input type="text" name="email" id="email" />
      </p>
      <p>
        <label for="addr">地址：</label>
        <input type="text" name="addr" id="addr" />
      </p>
      <p>
        <input name="hiddenField" type="hidden" id="hiddenField" value="小天使" />
        <input type="hidden" name="MM_insert" value="form1" />
      </p>
      <p>
        <input type="submit" name="SUBMIT" id="SUBMIT" value="送出" />
      </p>
      <p>&nbsp;</p>
    </form>
</div>

<div id="apDiv10"><img src="../圖/小天使註冊.png" width="350" height="69" /></div>
</div>
</body>
</html>