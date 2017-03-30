<?php require_once('Connections/enjoydata.php'); ?>
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

$MM_restrictGoTo = "log_in.php";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO goodsorder (goodsid, goodsname, num, price, cus_id, cus_name, tel, `add`, msg, name, `state`, email, totalprice) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['goodsid'], "int"),
                       GetSQLValueString($_POST['goodsname'], "text"),
                       GetSQLValueString($_POST['num'], "int"),
                       GetSQLValueString($_POST['price'], "double"),
                       GetSQLValueString($_POST['cus_id'], "int"),
                       GetSQLValueString($_POST['cus_name'], "text"),
                       GetSQLValueString($_POST['tel'], "text"),
                       GetSQLValueString($_POST['add'], "text"),
                       GetSQLValueString($_POST['msg'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['state'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['price']*$_POST['num'], "double"));

  mysql_select_db($database_ishop, $ishop);
  $Result1 = mysql_query($insertSQL, $ishop) or die(mysql_error());

  $insertGoTo = "orderok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
	$_POST['store_num']=$_POST['store_num']-$_POST['num'];
	$_POST['sell_num']=$_POST['sell_num']+$_POST['num'];
  $updateSQL = sprintf("UPDATE goods SET store_num=%s, sell_num=%s WHERE goodsid=%s",
                       GetSQLValueString($_POST['store_num'], "int"),
                       GetSQLValueString($_POST['sell_num'], "int"),
                       GetSQLValueString($_POST['goodsid'], "int"));

  mysql_select_db($database_ishop, $ishop);
  $Result1 = mysql_query($updateSQL, $ishop) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['goodsid'])) {
  $colname_Recordset1 = $_GET['goodsid'];
}
mysql_select_db($database_ishop, $ishop);
$query_Recordset1 = sprintf("SELECT * FROM goods WHERE goodsid = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $ishop) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset2 = $_SESSION['MM_Username'];
}
mysql_select_db($database_ishop, $ishop);
$query_Recordset2 = sprintf("SELECT * FROM user_reg WHERE username = %s", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $ishop) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>立即购买</title>
<style type="text/css">
.css1 {
	color: #FFF;
}
</style></head>

<body>
<div>
  <table bgcolor="#000000" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr align="center" valign="middle">
      <td width="230" height="30"><img src="images/title.png" width="230" height="30" /></td>
      <td height="30">&nbsp;</td>
      <td width="300" class="css1">欢迎来到我爱购<span class="css1">！
<?php 
	  if (!isset($_SESSION)) {
      session_start();
      }
	  if($_SESSION['MM_Username']=="")
	  {echo "请<a href='log_in.php'>登录</a>&nbsp;&nbsp;<a href='reg.php'>注册</a>";}
	  else
	  {echo "{$_SESSION['MM_Username']}&nbsp;&nbsp;<a href='log_out.php'>退出</a>";}
	  ?>
      </span></td>
      <td width="150" height="30" class="css1"><a href="myspace.php" target="_self">个人中心</a></td>
      <td width="100" height="30" class="css1">我的订单</td>
      <td width="100" class="css1">购物车</td>
      <td width="25%">&nbsp;</td>
    </tr>
  </table>
</div>
<p>
<table width="900" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr align="center" valign="middle">
    <td width="80" height="30">主页</td>
    <td width="80" height="30">服装鞋包</td>
    <td width="80" height="30">运动户外</td>
    <td width="80" height="30">家电数码</td>
    <td width="80" height="30">日用百货</td>
    <td width="80" height="30">文化娱乐</td>
    <td width="80" height="30">其他</td>
    <td height="30"><form id="form1" name="form1" method="post" action="">
      <label for="textfield"></label>
      <input name="textfield" type="text" id="textfield" size="30" />
      <input type="submit" name="button" id="button" value="搜索" />
    </form></td>
  </tr>
</table>
</p>
<form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="900" border="0" align="center">
    <tr>
      <td colspan="4"><b>填写订单</b></td>
    </tr>
    <tr>
      <td width="150">商品名称</td>
      <td width="300"><?php echo $row_Recordset1['goodsname']; ?></td>
      <td width="150">送货地址</td>
      <td width="300"><label for="add"></label>
      <input name="add" type="text" id="add" value="<?php echo $row_Recordset2['useradd']; ?>" /></td>
    </tr>
    <tr>
      <td>单价</td>
      <td><?php echo $row_Recordset1['price']; ?></td>
      <td>联系电话</td>
      <td><label for="tel"></label>
      <input name="tel" type="text" id="tel" value="<?php echo $row_Recordset2['usertel']; ?>" /></td>
    </tr>
    <tr>
      <td>购买数量</td>
      <td><label for="num"></label>
      <input name="num" type="text" id="num" value="1" /></td>
      <td>收货人姓名</td>
      <td><label for="name"></label>
      <input name="name" type="text" id="name" value="<?php echo $row_Recordset2['username']; ?>" /></td>
    </tr>
    <tr>
      <td>备注信息</td>
      <td><label for="msg"></label>
      <input name="msg" type="text" id="msg" value="无" /></td>
      <td>电子邮箱</td>
      <td><label for="email"></label>
      <input name="email" type="text" id="email" value="<?php echo $row_Recordset2['email']; ?>" /></td>
    </tr>
    <tr>
      <td><input name="goodsid" type="hidden" id="goodsid" value="<?php echo $row_Recordset1['goodsid']; ?>" />
      <input name="price" type="hidden" id="price" value="<?php echo $row_Recordset1['price']; ?>" />
      <input name="cus_id" type="hidden" id="cus_id" value="<?php echo $row_Recordset2['userid']; ?>" />
      <input name="cus_name" type="hidden" id="cus_name" value="<?php echo $row_Recordset2['username']; ?>" />
      <input name="goodsname" type="hidden" id="goodsname" value="<?php echo $row_Recordset1['goodsname']; ?>" />
      <input name="state" type="hidden" id="state" value="未付款" /></td>
      <td><input name="store_num" type="hidden" id="store_num" value="<?php echo $row_Recordset1['store_num']; ?>" />
      <input name="sell_num" type="hidden" id="sell_num" value="<?php echo $row_Recordset1['sell_num']; ?>" /></td>
      <td>&nbsp;</td>
      <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        <input type="submit" name="button2" id="button2" value="提交订单" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2" />
  <input type="hidden" name="MM_update" value="form2" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
