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
  $insertSQL = sprintf("INSERT INTO member (D_ID, D_PWD, D_NAME, D_TEL, D_EMAIL, D_CHAR) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ID'], "text"),
                       GetSQLValueString($_POST['PWD'], "text"),
                       GetSQLValueString($_POST['neme'], "text"),
                       GetSQLValueString($_POST['TEL'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['hiddenField'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>小主人註冊</title>
</head>

<body>
<p>小主人註冊</p>
<div>
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
        <input name="hiddenField" type="hidden" id="hiddenField" value="小主人" />
        <input type="hidden" name="MM_insert" value="form1" />
      </p>
      <p>
        <input type="submit" name="SUBMIT" id="SUBMIT" value="送出" />
      </p>
      <p>&nbsp;</p>
    </form>
  </div>
</div>
<p>&nbsp;</p>
</body>
</html>