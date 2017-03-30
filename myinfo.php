<?php require_once('Connections/enjoydata.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")&&(!empty($_FILES['head']['name']))) {
  $updateSQL = sprintf("UPDATE user_reg SET head=%s WHERE userid=%s",
                       GetSQLValueString($_POST['hiddenField'], "int"),
                       GetSQLValueString($_POST['hiddenField'], "int"));
	//$path1=AddSlashes(dirname(__FILE__))  . "\\\\images\\\\head\\\\";
  $path1='images/head/';
   if (is_uploaded_file($_FILES['head']['tmp_name'])) {
  		$filename = $_POST['hiddenField'].".gif"; 
		$localfile = $path1 . $filename;
		move_uploaded_file($_FILES['head']['tmp_name'], $localfile);
   	}

  mysql_select_db($database_enjoydata, $enjoydata);
  $Result1 = mysql_query($updateSQL, $enjoydata) or die(mysql_error());

  echo "<script> parent.location.reload()</script>";
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset1 = sprintf("SELECT * FROM user_reg WHERE username = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $enjoydata) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的信息</title>
</head>

<body>
<p>个人信息</p>
<table width="400" border="1">
  <tr>
    <td width="100" align="right" valign="top">头像</td>
    <td><img src="images/head/<?php echo $row_Recordset1['head']; ?>.gif" width="150" height="150" /></td>
  </tr>
  <tr>
    <td align="right">修改头像</td>
    <td><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <label for="head"></label>
      <input type="file" name="head" id="head" />
      <input type="submit" name="button" id="button" value="上传" />
      <input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_Recordset1['userid']; ?>" />
      <input type="hidden" name="MM_update" value="form1" />
    </form></td>
  </tr>
  <tr>
    <td align="right">用户名</td>
    <td><?php echo $row_Recordset1['username']; ?></td>
  </tr>
  <tr>
    <td align="right">地址</td>
    <td><?php echo $row_Recordset1['useradd']; ?></td>
  </tr>
  <tr>
    <td align="right">电子邮箱</td>
    <td><?php echo $row_Recordset1['email']; ?></td>
  </tr>
  <tr>
    <td align="right">联系电话</td>
    <td><?php echo $row_Recordset1['usertel']; ?></td>
  </tr>
  <tr>
    <td align="right">签名档</td>
    <td><?php echo $row_Recordset1['words']; ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><a href="changemyinfo.php?id=<?php echo $row_Recordset1['userid']; ?>" target="_self">修改信息</a></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
