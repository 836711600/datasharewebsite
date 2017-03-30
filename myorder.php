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

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_ishop, $ishop);
$query_Recordset1 = sprintf("SELECT * FROM goodsorder WHERE cus_name = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $ishop) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的订单</title>
<style type="text/css">
.css1 {
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
</style></head>

<body>
<p>我的订单 </p>
<table width="958" border="1">
  <tr>
    <td width="80" align="center">订单号</td>
    <td width="100" align="center">商品名</td>
    <td width="80" align="center">购买数量</td>
    <td width="80" align="center">单价</td>
    <td width="80" align="center">总价</td>
    <td width="100" align="center">备注</td>
    <td width="100" align="center">添加时间</td>
    <td width="80" align="center">状态</td>
    <td width="200" align="center">操作</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center"><?php echo $row_Recordset1['orderid']; ?></td>
      <td align="center"><a href="data.php?id=<?php echo $row_Recordset1['goodsid']; ?>" target="_blank"><?php echo $row_Recordset1['goodsname']; ?></a></td>
      <td align="center"><?php echo $row_Recordset1['num']; ?></td>
      <td align="center"><?php echo $row_Recordset1['price']; ?></td>
      <td align="center"><?php echo $row_Recordset1['totalprice']; ?></td>
      <td align="center"><?php echo $row_Recordset1['msg']; ?></td>
      <td align="center"><?php echo $row_Recordset1['addtime']; ?></td>
      <td align="center"><?php echo $row_Recordset1['state']; ?></td>
      <td align="center"><?php
	  if($row_Recordset1['state']=="未付款")
	  {
	   echo " <a href='deleteorder.php?orderid=".$row_Recordset1['orderid']."'><img src='images/deleteorder.png' width='123' height='35' class='css1' /></a>&nbsp;&nbsp;&nbsp;<input type=image src='images/paymoney.png' width='60' height='35' onClick='javascript:form".$row_Recordset1['orderid'].".submit();' class='css1' >";
	  }
       elseif($row_Recordset1['state']=="已付款")
	   {
	   echo "等待发货";
	   }
	   elseif($row_Recordset1['state']=="已发货")
	   {
	   echo "<a href='receivegoods.php?orderid=".$row_Recordset1['orderid']."'>确认收货</a>";
	   }
	   else 
	   {
	   echo "<a href='comment.php?goodsid=".$row_Recordset1['goodsid']."&orderid=".$row_Recordset1['orderid']."'>评价</a>";
	   }
       ?>
        <form id="form<?php echo $row_Recordset1['orderid']; ?>" name="form<?php echo $row_Recordset1['orderid']; ?>" method="post" target="_blank" action="db_php_utf8/alipayto.php">
          <input name="aliid" type="hidden" id="aliid" value="<?php echo $row_Recordset1['orderid']; ?>" />
          <input name="aliorder" type="hidden" id="aliorder" value="<?php echo $row_Recordset1['goodsname']; ?>" />
          <input name="alibody" type="hidden" id="alibody" value="<?php echo $row_Recordset1['msg']; ?>" />
          <input name="alimoney" type="hidden" id="alimoney" value="<?php echo $row_Recordset1['totalprice']; ?>" />
          <input name="aliname" type="hidden" id="aliname" value="<?php echo $row_Recordset1['name']; ?>" />
          <input name="aliadd" type="hidden" id="aliadd" value="<?php echo $row_Recordset1['add']; ?>" />
          <input name="alitel" type="hidden" id="alitel" value="<?php echo $row_Recordset1['tel']; ?>" />
      </form></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<p class="css1">&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
