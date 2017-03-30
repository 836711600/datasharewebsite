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
  $updateGoTo = "search.php?search=%".urlencode($_POST['textfield'])."%";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_GET['goodsclass'])) {
  $colname_Recordset1 = $_GET['goodsclass'];
}
mysql_select_db($database_ishop, $ishop);
$query_Recordset1 = sprintf("SELECT * FROM goods WHERE goodsclass = %s ORDER BY sell_num DESC", GetSQLValueString($colname_Recordset1, "text"));
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $ishop) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品分类</title>
<style type="text/css">
.css1 {	color: #FFF;
}
</style>
</head>

<body>
<div>
  <table bgcolor="#000000" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr align="center" valign="middle">
      <td width="230" height="30"><img src="images/title.png" width="230" height="30" /></td>
      <td height="30">&nbsp;</td>
      <td width="300" class="css1">欢迎来到我爱购！
        <?php 
	  if (!isset($_SESSION)) {
      session_start();
      }
	  if($_SESSION['MM_Username']=="")
	  {echo "请<a href='log_in.php'>登录</a>&nbsp;&nbsp;<a href='reg.php'>注册</a>";}
	  else
	  {echo "{$_SESSION['MM_Username']}&nbsp;&nbsp;<a href='log_out.php'>退出</a>";}
	  ?></td>
      <td width="150" height="30" class="css1"><a href="myspace.php" target="_blank">个人中心</a></td>
      <td width="100" height="30" class="css1"><a href="myspace1.php" target="_blank">我的订单</a></td>
      <td width="100" class="css1"><a href="myspace2.php" target="_blank">购物车</a></td>
      <td width="100" class="css1">&nbsp;</td>
      <td width="13%">&nbsp;</td>
    </tr>
  </table>
</div>
<p>&nbsp;</p>
<table width="900" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr align="center" valign="middle">
    <td width="80" height="30"><a href="index.php">主页</a></td>
    <td width="80" height="30"><a href="class.php?goodsclass=<?php echo urlencode('服装鞋包');?>" target="_blank">服装鞋包</a></td>
    <td width="80" height="30"><a href="class.php?goodsclass=<?php echo urlencode('运动户外');?>" target="_blank">运动户外</a></td>
    <td width="80" height="30"><a href="class.php?goodsclass=<?php echo urlencode('家电数码');?>" target="_blank">家电数码</a></td>
    <td width="80" height="30"><a href="class.php?goodsclass=<?php echo urlencode('日用百货');?>" target="_blank">日用百货</a></td>
    <td width="80" height="30"><a href="class.php?goodsclass=<?php echo urlencode('文化娱乐');?>" target="_blank">文化娱乐</a></td>
    <td width="80" height="30"><a href="class.php?goodsclass=<?php echo urlencode('其他');?>" target="_blank">其他</a></td>
    <td height="30"><form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>"  target="_blank" >
      <label for="textfield"></label>
      <input name="textfield" type="text" id="textfield" size="30" />
      <input type="submit" name="button" id="button" value="搜索" />
      <input type="hidden" name="MM_update" value="form1" />
    </form></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="900" border="0" align="center">
  <tr>
    <td>商品列表&nbsp;&nbsp; &nbsp; 主页&gt;<?php echo $row_Recordset1['goodsclass']; ?></td>
  </tr>
</table>
<p><hr width="900" align="center" />
</p>
<?php do { ?>
  <table width="900" border="0" align="center">
    <tr>
      <td width="100" height="100" rowspan="3" align="center"><img src="images/face/<?php echo $row_Recordset1['face']; ?>.gif" width="100" height="100" /></td>
      <td width="200" height="50" rowspan="2" align="center"><a href="data.php?id=<?php echo $row_Recordset1['goodsid']; ?>"><?php echo $row_Recordset1['goodsname']; ?></a></td>
      <td width="50" rowspan="3" align="center">&nbsp;</td>
      <td width="150" height="30" align="center" valign="bottom">￥&nbsp; <font color="#FF0000"><?php echo $row_Recordset1['price']; ?></font></td>
      <td width="50" rowspan="3" align="center">&nbsp;</td>
      <td width="150" rowspan="2" align="center" valign="bottom">销售量：<?php echo $row_Recordset1['sell_num']; ?></td>
      <td width="50" rowspan="3" align="center">&nbsp;</td>
      <td width="150" rowspan="3" align="center"><img src="images/baozhang.png" width="150" height="50" /></td>
    </tr>
    <tr>
      <td height="30" align="center" valign="bottom">运费：0.00</td>
    </tr>
    <tr>
      <td width="200" height="50" align="center"><img src="images/title.png" width="180" height="30" /></td>
      <td height="40" align="center">支付宝安全交易</td>
      <td align="center">顶：<?php echo $row_Recordset1['good']; ?>&nbsp; &nbsp;踩：<?php echo $row_Recordset1['bad']; ?></td>
    </tr>
  </table>
  <hr width="900" align="center" />
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
<p><table width="900" border="0" align="center">
  <tr>
    <td align="center" valign="middle">&nbsp;
      <table border="0">
        <tr>
          <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">第一页</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">前一页</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">下一页</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">最后一页</a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
</table>
&nbsp;</p>
<hr width="900" align="center" />
<table width="900" border="0" align="center">
  <tr align="right">
    <td>Powered By ishop.com</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
