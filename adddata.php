<?php require_once('Connections/enjoydata.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO updata (dataname, note, source, update_time, `class`, uper, state) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['dataname'], "text"),
                       GetSQLValueString($_POST['note'], "text"),
                       GetSQLValueString($_POST['source'], "text"),
                       GetSQLValueString(date('y-m-d H:i:s',time()), "date"),
                       GetSQLValueString($_POST['class'], "text"),
                       GetSQLValueString($_POST['uper'], "text"),
					   GetSQLValueString("待审核", "text"));

  mysql_select_db($database_enjoydata, $enjoydata);
  $Result1 = mysql_query($insertSQL, $enjoydata) or die(mysql_error());

  $insertGoTo = "mydata.php";
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
<title>添加商品</title>
</head>

<body>
<p>上传数据</p>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table width="100%" border="0">
    <tr>
      <td width="50" align="right">名称</td>
      <td><label for="dataname"></label>
      <input type="text" name="dataname" id="dataname" /></td>
    </tr>
    <tr>
      <td align="right">来源</td>
      <td><label for="source"></label>
      <input type="text" name="source" id="source" /></td>
    </tr>
    <tr>
      <td align="right">分类</td>
      <td><label for="source"></label>
        <label for="class"></label>
        <select name="class" id="class">
          <option value="农业" selected="selected">农业</option>
          <option value="商业">商业</option>
          <option value="气候">气候</option>
          <option value="消费">消费</option>
          <option value="教育">教育</option>
          <option value="能源">能源</option>
          <option value="金融">金融</option>
          <option value="医疗">医疗</option>
          <option value="科研">科研</option>
          <option value="其他">其他</option>
      </select></td>
    </tr>
    

    <tr>
      <td align="right">说明</td>
      <td align="left"><label for="note"></label>
      <textarea name="note" id="note" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td align="right"><input name="uper" type="hidden" id="uper" value="<?php echo $_SESSION['MM_Username']; ?>" /></td>
      <td align="left"><input type="submit" name="button" id="button" value="添加" />
        &nbsp;&nbsp;&nbsp;
<input type="reset" name="button2" id="button2" value="重填" />
<label for="textfield"></label></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>