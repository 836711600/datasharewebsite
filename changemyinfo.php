<?php require_once('Connections/enjoydata.php'); ?>
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
  $updateSQL = sprintf("UPDATE user_reg SET password=%s, useradd=%s, email=%s, usertel=%s, words=%s WHERE userid=%s",
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['user_add'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['user_tel'], "text"),
                       GetSQLValueString($_POST['words'], "text"),
                       GetSQLValueString($_POST['hiddenField'], "int"));
  mysql_select_db($database_enjoydata, $enjoydata);
  $Result1 = mysql_query($updateSQL, $enjoydata) or die(mysql_error());

   echo "<script> parent.location.reload()</script>";
}

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset1 = sprintf("SELECT * FROM user_reg WHERE userid = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $enjoydata) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>

修改信息
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table width="100%" border="1">
      <td align="right">新密码</td>
      <td><label for="password"></label>
      <input name="password" type="password" id="password" value="<?php echo $row_Recordset1['password']; ?>" /></td>
    </tr>
    <tr>
      <td align="right">确认密码</td>
      <td><label for="password2"></label>
      <input name="password2" type="password" id="password2" value="<?php echo $row_Recordset1['password']; ?>" /></td>
    </tr>
    <tr>
      <td align="right">地址</td>
      <td><label for="user_add"></label>
      <input name="user_add" type="text" id="user_add" value="<?php echo $row_Recordset1['useradd']; ?>" /></td>
    </tr>
    <tr>
      <td align="right">电子邮箱</td>
      <td><label for="email"></label>
      <input name="email" type="text" id="email" value="<?php echo $row_Recordset1['email']; ?>" /></td>
    </tr>
    <tr>
      <td align="right">联系电话</td>
      <td><label for="user_tel"></label>
      <input name="user_tel" type="text" id="user_tel" value="<?php echo $row_Recordset1['usertel']; ?>" /></td>
    </tr>
    <tr>
      <td align="right">签名档</td>
      <td><label for="words"></label>
      <input name="words" type="text" id="words" value="<?php echo $row_Recordset1['words']; ?>" /></td>
    </tr>
    <tr>
      <td align="right"><input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_Recordset1['userid']; ?>" /></td>
      <td><input type="submit" name="button" id="button" value="修改" />
      &nbsp;&nbsp;&nbsp;<a href="myinfo.php" target="_self">取消修改</a></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
