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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")&&(!empty($_FILES['upfile']['name']))) {
  $insertSQL = sprintf("INSERT INTO upfile (name, `size`, type, dataid) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_FILES['upfile']['name'], "text"),
                       GetSQLValueString($_FILES['upfile']['size'], "double"),
                       GetSQLValueString(substr($_FILES['upfile']['name'], strrpos($_FILES['upfile']['name'], '.') + 1), "text"),
                       GetSQLValueString($_POST['dataid'], "int"));
					   
  if (!is_dir('files/'.$_POST['dataid'])) mkdir('files/'.$_POST['dataid']);
   $path1=AddSlashes(dirname(__FILE__))  . "\\\\files\\\\".$_POST['dataid']."\\\\";
   if (is_uploaded_file($_FILES['upfile']['tmp_name'])) {
		$localfile = $path1 . iconv("UTF-8", "GBK", $_FILES['upfile']['name']);
		move_uploaded_file($_FILES['upfile']['tmp_name'], $localfile);
   	}
  

  mysql_select_db($database_enjoydata, $enjoydata);
  $Result1 = mysql_query($insertSQL, $enjoydata) or die(mysql_error());

  $insertGoTo = "admin_data_detail.php?id=".$row_Recordset1['dataid'];
    if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

$colname_Recordset2 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset2 = $_GET['id'];
}
mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset2 = sprintf("SELECT * FROM upfile WHERE dataid = %s ORDER BY fileid ASC", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $enjoydata) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<p>数据详情</p>
<table width="100%" border="1">
  <tr>
    <td align="right">名称</td>
    <td align="left"><?php echo $row_Recordset1['dataname']; ?></td>
  </tr>
  <tr>
    <td align="right">分类</td>
    <td align="left"><?php echo $row_Recordset1['class']; ?></td>
  </tr>
  <tr>
    <td align="right">来源</td>
    <td align="left"><?php echo $row_Recordset1['source']; ?></td>
  </tr>
  <tr>
    <td align="right">上传时间</td>
    <td align="left"><?php echo $row_Recordset1['creat_time']; ?></td>
  </tr>
  <tr>
    <td align="right">更新时间</td>
    <td align="left"><?php echo $row_Recordset1['update_time']; ?></td>
  </tr>
  <tr>
    <td align="right">描述</td>
    <td align="left"><?php echo $row_Recordset1['note']; ?></td>
  </tr>
</table>
<p>Dateset</p>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
上传文件
  <label for="upfile"></label>
  <input type="file" name="upfile" id="upfile" />
  <input type="submit" name="button" id="button" value="上传" />
  <input name="dataid" type="hidden" id="dataid" value="<?php echo $row_Recordset1['dataid']; ?>" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<table width="100%" border="1">
  <tr>
    <td align="center">文件名</td>
    <td align="center">格式</td>
    <td align="center">大小</td>
    <td align="center">上传时间</td>
    <td align="center">操作</td>
  </tr>
  <?php if($totalRows_Recordset2>0){do { ?>
    <tr>
      <td align="center"><?php echo $row_Recordset2['name']; ?></td>
      <td align="center"><?php echo $row_Recordset2['type']; ?></td>
      <td align="center"><?php echo $row_Recordset2['size']; ?>字节</td>
      <td align="center"><?php echo $row_Recordset2['uptime']; ?></td>
      <td align="center"><a href="admin_deletefile.php?id=<?php echo $row_Recordset2['fileid']; ?>&dataid=<?php echo $row_Recordset1['dataid']; ?>">删除</a></td>
    </tr>
    <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));}; ?>
</table>
<p><a href="admin_data.php">返回</a></p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
