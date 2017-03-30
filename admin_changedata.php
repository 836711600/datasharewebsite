<?php require_once('Connections/enjoydata.php'); ?>
<?php
date_default_timezone_set('Asia/Hong_Kong'); 
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
  $updateSQL = sprintf("UPDATE updata SET dataname=%s, note=%s, source=%s, update_time=%s WHERE dataid=%s",
                       GetSQLValueString($_POST['dataname'], "text"),
                       GetSQLValueString($_POST['note'], "text"),
                       GetSQLValueString($_POST['source'], "text"),
                       GetSQLValueString(date('y-m-d H:i:s',time()), "date"),
                       GetSQLValueString($_POST['dataid'], "int"));

  mysql_select_db($database_enjoydata, $enjoydata);
  $Result1 = mysql_query($updateSQL, $enjoydata) or die(mysql_error());

  $updateGoTo = "admin_data.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset1 = sprintf("SELECT * FROM updata WHERE dataid = %s", GetSQLValueString($colname_Recordset1, "int"));
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
  修改数据

<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
<table width="100%" border="0">
    <tr>
      <td width="50" align="right">名称</td>
      <td><label for="dataname"></label>
      <input name="dataname" type="text" id="dataname" value="<?php echo $row_Recordset1['dataname']; ?>" /></td>
    </tr>
    <tr>
      <td align="right">来源</td>
      <td><label for="source"></label>
      <input name="source" type="text" id="source" value="<?php echo $row_Recordset1['source']; ?>" /></td>
    </tr>
   
    

  <tr>
      <td align="right">说明</td>
      <td align="left"><label for="note"></label>
      <textarea name="note" id="note" cols="45" rows="5"><?php echo $row_Recordset1['note']; ?></textarea></td>
    </tr>
    <tr>
      <td align="right"><input name="dataid" type="hidden" id="dataid" value="<?php echo $row_Recordset1['dataid']; ?>" /></td>
      <td align="left"><input type="submit" name="button" id="button" value="修改" />
      <label for="textfield"><a href="admin_data.php">取消修改</a></label></td>
    </tr>
  </table>
<input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
