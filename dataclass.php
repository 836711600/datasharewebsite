<?php require_once('Connections/enjoydata.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
error_reporting(E_ALL ^ E_NOTICE);
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_GET['class'])) {
  $colname_Recordset1 = $_GET['class'];
}
mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset1 = sprintf("SELECT * FROM updata WHERE `class` = %s AND `state` = '审核通过' ORDER BY update_time DESC", GetSQLValueString($colname_Recordset1, "text"));
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
                //    return false;
               // }
            });
        });
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_GET['class']; ?></title>
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
            <input type="text" name="keyword" id="search" />
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
      <td align="left"><h2>主页><?php echo $_GET['class']; ?></h2></td>
    </tr>
  </table>
  </p>
  <?php do { ?>
  <p><table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="100" align="right" valign="top">数据名称：</td>
      <td align="left"><a href="data.php?id=<?php echo $row_Recordset1['dataid']; ?>"><?php echo $row_Recordset1['dataname']; ?></a></td>
    </tr>
    <tr>
      <td align="right" valign="top">数据来源：</td>
      <td align="left"><?php echo $row_Recordset1['source']; ?></td>
    </tr>
    <tr>
      <td align="right" valign="top">数据描述：</td>
      <td align="left"><?php echo $row_Recordset1['note']; ?></td>
    </tr>
  </table>
  </p>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  <table border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">第一页&nbsp;&nbsp;</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">前一页&nbsp;&nbsp;</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">下一个&nbsp;&nbsp;</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">最后一页</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
