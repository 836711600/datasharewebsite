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

$maxRows_Recordset1 = 4;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset1 = "SELECT dataid, dataname, update_time FROM updata WHERE `class` = '农业' AND `state` = '审核通过' ORDER BY update_time DESC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $enjoydata) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset2 = "SELECT dataid, dataname, update_time FROM updata WHERE `class` = '商业' AND `state` = '审核通过' ORDER BY update_time DESC LIMIT 0,4";
$Recordset2 = mysql_query($query_Recordset2, $enjoydata) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset3 = "SELECT dataid, dataname, update_time FROM updata WHERE `class` = '气候' AND `state` = '审核通过' ORDER BY update_time DESC LIMIT 0,4";
$Recordset3 = mysql_query($query_Recordset3, $enjoydata) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset4 = "SELECT dataid, dataname, update_time FROM updata WHERE `class` = '消费' AND `state` = '审核通过' ORDER BY update_time DESC LIMIT 0,4";
$Recordset4 = mysql_query($query_Recordset4, $enjoydata) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset5 = "SELECT dataid, dataname, update_time FROM updata WHERE `class` = '教育' AND `state` = '审核通过' ORDER BY update_time DESC LIMIT 0,4";
$Recordset5 = mysql_query($query_Recordset5, $enjoydata) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset6 = "SELECT dataid, dataname, update_time FROM updata WHERE `class` = '能源' AND `state` = '审核通过' ORDER BY update_time DESC LIMIT 0,4";
$Recordset6 = mysql_query($query_Recordset6, $enjoydata) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset7 = "SELECT dataid, dataname, update_time FROM updata WHERE `class` = '金融' AND `state` = '审核通过' ORDER BY update_time DESC LIMIT 0,4";
$Recordset7 = mysql_query($query_Recordset7, $enjoydata) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset8 = "SELECT dataid, dataname, update_time FROM updata WHERE `class` = '医疗' AND `state` = '审核通过' ORDER BY update_time DESC LIMIT 0,4";
$Recordset8 = mysql_query($query_Recordset8, $enjoydata) or die(mysql_error());
$row_Recordset8 = mysql_fetch_assoc($Recordset8);
$totalRows_Recordset8 = mysql_num_rows($Recordset8);

mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset9 = "SELECT dataid, dataname, update_time FROM updata WHERE `class` = '科研' AND `state` = '审核通过' ORDER BY update_time DESC LIMIT 0,4";
$Recordset9 = mysql_query($query_Recordset9, $enjoydata) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset10 = "SELECT dataid, dataname, update_time FROM updata WHERE `class` = '其他' AND `state` = '审核通过' ORDER BY update_time DESC LIMIT 0,4";
$Recordset10 = mysql_query($query_Recordset10, $enjoydata) or die(mysql_error());
$row_Recordset10 = mysql_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysql_num_rows($Recordset10);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
if (!isset($_SESSION)) {
  session_start();
}
error_reporting(E_ALL ^ E_NOTICE);
?>
<link href="css/style.css" rel="stylesheet" media="screen" />
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen">
<script type="text/javascript" src="js/jquery-1.2.3.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.min.js"></script>
<script type="text/javascript" src="js/jquery.mainmenuslide.js"></script>
<script type="text/javascript">
        $(function() {
            $("ul").mainmenuslide({
                fx: "backout",
                speed: 700,
               // click: function(event, menuItem) {
               //     return false;
               // }
            });
        });
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EnjoyData</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	text-align: center;
	vertical-align: middle;
}
.css1 {
	color: #FFF;
	font-size: 18px;
}

.css2 {
	height: 70px;
	width: 720px;
}
.css3 {
	height: 75px;
	width: 75px;
}
a{text-decoration:none;}
#search {
	height: 40px;
	width: 500px;
	float: left;
}
#searchbutton {
	height: 46px;
	width: 80px;
	float: left;
}
.middle{
	MARGIN-RIGHT: auto;
	 MARGIN-LEFT: auto;
	 width:600px;
}
a:link, a:visited {color:blue;}
</style>
</head>

<body>
<div>
  <table bgcolor="#000000" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr align="center" valign="middle">
      <td width="230" height="50"><a href="index.php"><img src="images/title.png" width="230" height="50" /></a></td>
      <td height="50">&nbsp;</td>
      <td width="300" class="css1"><span class="css1">欢迎来到EnjoyData！
      <?php 
	  if (!isset($_SESSION)) {
      session_start();
      }
	  if($_SESSION['MM_Username']=="")
	  {echo "请<a href='log_in.php'>登录</a>&nbsp;<a href='reg.php'>注册</a>";}
	  else
	  {echo "{$_SESSION['MM_Username']}&nbsp;&nbsp;<a href='log_out.php'>退出</a>";}
	  ?>
      </span></td>
      <td width="150" height="50" class="css1"><a href="myspace.php" target="_blank">个人中心</a></td>
      <td width="100" height="50" class="css1"><a href="myspace1.php" target="_blank">我的数据</a></td>
      <td width="100" class="css1"><a href="myspace2.php" target="_blank">我要上传</a></td>
      <td width="100" class="css1">
      <?php
      if($_SESSION['MM_UserGroup']==1)
      echo "<a href='admin.php' target='_blank'>管理中心</a>";
	  ?>
      </td>
      <td width="13%">&nbsp;</td>
    </tr>
  </table>
</div>
<p>
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr align="center" valign="middle">
    <td>
    <div class="middle">
    <form action="search.php" method="post" name="form2" target="_blank" id="form2">
      <label for="keyword"></label>
      <input type="text" name="keyword" id="search" value="教育"/>
      <input type="submit" name="button2" id="searchbutton" value="搜索" />
    </form>
    </div>
    </td>
  </tr>
</table>

</p>
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr align="center">
    <td>
<div class="header_navigation" >
    	<ul class="mainmenuslide" >
        	<li><a target="_blank" href="dataclass.php?class=<?php echo urlencode('农业'); ?>" style="color:#FFF">农业</a></li>
            <li><a target="_blank" href="dataclass.php?class=<?php echo urlencode('商业'); ?>" style="color:#FFF">商业</a></li>
            <li><a target="_blank" href="dataclass.php?class=<?php echo urlencode('气候'); ?>" style="color:#FFF">气候</a></li>
            <li><a target="_blank" href="dataclass.php?class=<?php echo urlencode('消费'); ?>" style="color:#FFF">消费</a></li>
            <li><a target="_blank" href="dataclass.php?class=<?php echo urlencode('教育'); ?>" style="color:#FFF">教育</a></li>
            <li><a target="_blank" href="dataclass.php?class=<?php echo urlencode('能源'); ?>" style="color:#FFF">能源</a></li>
             <li><a target="_blank" href="dataclass.php?class=<?php echo urlencode('金融'); ?>" style="color:#FFF">金融</a></li>
               <li><a target="_blank" href="dataclass.php?class=<?php echo urlencode('医疗'); ?>" style="color:#FFF">医疗</a></li>
                <li><a target="_blank" href="dataclass.php?class=<?php echo urlencode('科研'); ?>" style="color:#FFF">科研</a></li>
                 <li><a target="_blank" href="dataclass.php?class=<?php echo urlencode('其他'); ?>" style="color:#FFF">其他</a></li>
        </ul>
</div>
</td>
  </tr>
</table>
<p><table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100" height="120" rowspan="4" align="center" valign="middle"><a target="_blank" href="dataclass.php?class=<?php echo urlencode('农业'); ?>"><img src="images/class/1.gif" width="100" height="100" /></a><br>农业</td>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <?php do { ?>
  <tr>
    <td width="600" height="30" align="left"><a href="data.php?id=<?php echo $row_Recordset1['dataid']; ?>"><?php echo $row_Recordset1['dataname']; ?></td>
    <td><?php echo $row_Recordset1['update_time']; ?></td>
  </tr>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</td>
</tr>
</table>

<hr width="900" align="center" />

<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100" height="120" rowspan="4" align="center" valign="middle"><a target="_blank" href="dataclass.php?class=<?php echo urlencode('商业'); ?>"><img src="images/class/2.gif" width="100" height="100" /></a><br>
      商业</td>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <?php do { ?>
  <tr>
    <td width="600" height="30" align="left"><a href="data.php?id=<?php echo $row_Recordset2['dataid']; ?>"><?php echo $row_Recordset2['dataname']; ?></td>
    <td><?php echo $row_Recordset2['update_time']; ?></td>
  </tr>
  <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
</table>
</td>
</tr>
</table>

<hr width="900" align="center" />

<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100" height="120" rowspan="4" align="center" valign="middle"><a target="_blank" href="dataclass.php?class=<?php echo urlencode('气候'); ?>"><img src="images/class/3.gif" width="100" height="100" /></a><br>
      气候</td>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <?php do { ?>
  <tr>
    <td width="600" height="30" align="left"><a href="data.php?id=<?php echo $row_Recordset3['dataid']; ?>"><?php echo $row_Recordset3['dataname']; ?></td>
    <td><?php echo $row_Recordset3['update_time']; ?></td>
  </tr>
  <?php } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)); ?>
</table>
</td>
</tr>
</table>

<hr width="900" align="center" />

<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100" height="120" rowspan="4" align="center" valign="middle"><a target="_blank" href="dataclass.php?class=<?php echo urlencode('消费'); ?>"><img src="images/class/4.gif" width="100" height="100" /></a><br>
      消费</td>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <?php do { ?>
  <tr>
    <td width="600" height="30" align="left"><a href="data.php?id=<?php echo $row_Recordset4['dataid']; ?>"><?php echo $row_Recordset4['dataname']; ?></td>
    <td><?php echo $row_Recordset4['update_time']; ?></td>
  </tr>
  <?php } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)); ?>
</table>
</td>
</tr>
</table>

<hr width="900" align="center" />

<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100" height="120" rowspan="4" align="center" valign="middle"><a target="_blank" href="dataclass.php?class=<?php echo urlencode('教育'); ?>"><img src="images/class/5.gif" width="100" height="100" /></a><br>
      教育</td>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <?php do { ?>
  <tr>
    <td width="600" height="30" align="left"><a href="data.php?id=<?php echo $row_Recordset5['dataid']; ?>"><?php echo $row_Recordset5['dataname']; ?></td>
    <td><?php echo $row_Recordset5['update_time']; ?></td>
  </tr>
  <?php } while ($row_Recordset5 = mysql_fetch_assoc($Recordset5)); ?>
</table>
</td>
</tr>
</table>

<hr width="900" align="center" />

<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100" height="120" rowspan="4" align="center" valign="middle"><a target="_blank" href="dataclass.php?class=<?php echo urlencode('能源'); ?>"><img src="images/class/6.gif" width="100" height="100" /></a><br>
      能源</td>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <?php do { ?>
  <tr>
    <td width="600" height="30" align="left"><a href="data.php?id=<?php echo $row_Recordset6['dataid']; ?>"><?php echo $row_Recordset6['dataname']; ?></td>
    <td><?php echo $row_Recordset6['update_time']; ?></td>
  </tr>
  <?php } while ($row_Recordset6 = mysql_fetch_assoc($Recordset6)); ?>
</table>
</td>
</tr>
</table>

<hr width="900" align="center" />

<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100" height="120" rowspan="4" align="center" valign="middle"><a target="_blank" href="dataclass.php?class=<?php echo urlencode('金融'); ?>"><img src="images/class/7.gif" width="100" height="100" /></a><br>
      金融</td>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <?php do { ?>
  <tr>
    <td width="600" height="30" align="left"><a href="data.php?id=<?php echo $row_Recordset7['dataid']; ?>"><?php echo $row_Recordset7['dataname']; ?></td>
    <td><?php echo $row_Recordset7['update_time']; ?></td>
  </tr>
  <?php } while ($row_Recordset7 = mysql_fetch_assoc($Recordset7)); ?>
</table>
</td>
</tr>
</table>

<hr width="900" align="center" />

<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100" height="120" rowspan="4" align="center" valign="middle"><a target="_blank" href="dataclass.php?class=<?php echo urlencode('医疗'); ?>"><img src="images/class/8.gif" width="100" height="100" /></a><br>
      医疗</td>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <?php do { ?>
  <tr>
    <td width="600" height="30" align="left"><a href="data.php?id=<?php echo $row_Recordset8['dataid']; ?>"><?php echo $row_Recordset8['dataname']; ?></td>
    <td><?php echo $row_Recordset8['update_time']; ?></td>
  </tr>
  <?php } while ($row_Recordset8 = mysql_fetch_assoc($Recordset8)); ?>
</table>
</td>
</tr>
</table>

<hr width="900" align="center" />

<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100" height="120" rowspan="4" align="center" valign="middle"><a target="_blank" href="dataclass.php?class=<?php echo urlencode('科研'); ?>"><img src="images/class/10.gif" width="100" height="100" /></a><br>
      科研</td>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <?php do { ?>
  <tr>
    <td width="600" height="30" align="left"><a href="data.php?id=<?php echo $row_Recordset9['dataid']; ?>"><?php echo $row_Recordset9['dataname']; ?></td>
    <td><?php echo $row_Recordset9['update_time']; ?></td>
  </tr>
  <?php } while ($row_Recordset9 = mysql_fetch_assoc($Recordset9)); ?>
</table>
</td>
</tr>
</table>

<hr width="900" align="center" />

<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100" height="120" rowspan="4" align="center" valign="middle"><a target="_blank" href="dataclass.php?class=<?php echo urlencode('其他'); ?>"><img src="images/class/11.gif" width="100" height="100" /></a><br>
      其他</td>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <?php do { ?>
  <tr>
    <td width="600" height="30" align="left"><a href="data.php?id=<?php echo $row_Recordset10['dataid']; ?>"><?php echo $row_Recordset10['dataname']; ?></td>
    <td><?php echo $row_Recordset10['update_time']; ?></td>
  </tr>
  <?php } while ($row_Recordset10 = mysql_fetch_assoc($Recordset10)); ?>
</table>
</td>
</tr>
</table>

</p>
<hr width="900" align="center" />
<table width="900" border="0" align="center">
  <tr align="right">
    <td>Powered By EnjoyData</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
mysql_free_result($Recordset2);
mysql_free_result($Recordset3);
mysql_free_result($Recordset4);
mysql_free_result($Recordset5);
mysql_free_result($Recordset6);
mysql_free_result($Recordset7);
mysql_free_result($Recordset8);
mysql_free_result($Recordset9);
mysql_free_result($Recordset10);
?>
