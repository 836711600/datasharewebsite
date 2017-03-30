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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO data_comment (content, dataid, username) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['textarea'], "text"),
                       GetSQLValueString($_GET['id'], "int"),
                       GetSQLValueString(empty($_SESSION['MM_Username'])?"匿名":$_SESSION['MM_Username'], "text"));

  mysql_select_db($database_enjoydata, $enjoydata);
  $Result1 = mysql_query($insertSQL, $enjoydata) or die(mysql_error());

  $insertGoTo = "data.php?id=".$_GET['id'];
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
$query_Recordset1 = sprintf("SELECT dataid,dataname,note,source,creat_time,update_time,data.class,uper,words,head FROM updata as data,user_reg as user WHERE data.dataid = %s AND data.uper=user.username", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $enjoydata) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset2 = $_GET['id'];
}
mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset2 = sprintf("SELECT * FROM upfile WHERE dataid = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $enjoydata) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$maxRows_Recordset3 = 10;
$pageNum_Recordset3 = 0;
if (isset($_GET['pageNum_Recordset3'])) {
  $pageNum_Recordset3 = $_GET['pageNum_Recordset3'];
}
$startRow_Recordset3 = $pageNum_Recordset3 * $maxRows_Recordset3;

$colname_Recordset3 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset3 = $_GET['id'];
}
mysql_select_db($database_enjoydata, $enjoydata);
$query_Recordset3 = sprintf("SELECT content,comment.username,time,head FROM data_comment as comment,user_reg as user WHERE comment.dataid = %s AND comment.username =user.username ORDER BY commentid DESC", GetSQLValueString($colname_Recordset3, "int"));
$query_limit_Recordset3 = sprintf("%s LIMIT %d, %d", $query_Recordset3, $startRow_Recordset3, $maxRows_Recordset3);
$Recordset3 = mysql_query($query_limit_Recordset3, $enjoydata) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);

if (isset($_GET['totalRows_Recordset3'])) {
  $totalRows_Recordset3 = $_GET['totalRows_Recordset3'];
} else {
  $all_Recordset3 = mysql_query($query_Recordset3);
  $totalRows_Recordset3 = mysql_num_rows($all_Recordset3);
}
$totalPages_Recordset3 = ceil($totalRows_Recordset3/$maxRows_Recordset3)-1;

$queryString_Recordset3 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset3") == false && 
        stristr($param, "totalRows_Recordset3") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset3 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset3 = sprintf("&totalRows_Recordset3=%d%s", $totalRows_Recordset3, $queryString_Recordset3);
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
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>数据详情-<?php echo $row_Recordset1['dataname']; ?></title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
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
</style></head>

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



<p>

<table width="900" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#666666">
  <tr>
    <td height="30"><b><font size="+3"><?php echo $row_Recordset1['dataname']; ?></font></b></td>
    <td width="90" height="90" rowspan="3"><img width="90" height="90" src="images/head/<?php echo $row_Recordset1['head']; ?>.gif"/></td>
    <td width="200" height="30"><b><?php echo $row_Recordset1['uper']; ?></b></td>
  </tr>
  <tr>
    <td height="30">主页&gt;<?php echo $row_Recordset1['class']; ?><br>
    上传时间:<?php echo $row_Recordset1['creat_time']; ?></td>
    <td rowspan="2" valign="top"><?php echo $row_Recordset1['words']; ?></td>
  </tr>
  <tr>
    <td height="20" valign="baseline"><hr /></td>
  </tr>
</table>
</p>
<p>
<table width="900" border="0" align="center">
  <tr>
    <td height="30" bgcolor="#666666"><b>数据详情</b></td>
  </tr>
</table>
<table width="900" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="300" align="right" valign="top">名称</td>
    <td align="left" valign="top"><?php echo $row_Recordset1['dataname']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="top">来源</td>
    <td align="left" valign="top"><?php echo $row_Recordset1['source']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="top">分类</td>
    <td align="left" valign="top"><?php echo $row_Recordset1['class']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="top">说明</td>
    <td align="left" valign="top"><?php echo $row_Recordset1['note']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="top">上传时间</td>
    <td align="left" valign="top"><?php echo $row_Recordset1['creat_time']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="top">更新时间</td>
    <td align="left" valign="top"><?php echo $row_Recordset1['update_time']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="top">上传者</td>
    <td align="left" valign="top"><?php echo $row_Recordset1['uper']; ?></td>
  </tr>
</table>

</p>

<p>
<table width="900" border="0" align="center">
  <tr>
    <td bgcolor="#666666"><b>数据下载</b></td>
  </tr>
</table>
<table width="900" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="600" align="center">文件名称</td>
    <td width="150" align="center">文件大小</td>
    <td align="center">操作</td>
  </tr>
  <?php if($totalRows_Recordset2>0){do { ?>
    <tr>
      <td align="center"><?php echo $row_Recordset2['name']; ?></td>
      <td align="center"><?php echo $row_Recordset2['size']; ?>字节</td>
      <td align="center"><a href="files/<?php echo $row_Recordset2['dataid']; ?>/<?php echo $row_Recordset2['name']; ?>">下载</a><?php if($row_Recordset2['type']=="pdf"){echo "|<a target='_blank' href=pdfviewer.php?id=".$row_Recordset2['dataid']."&name=".urlencode($row_Recordset2['name']).">预览</a>";}
	  //if($row_Recordset2['type']=="doc"||$row_Recordset2['type']=="docx"){echo "|<a target='_blank' href=wordviewer.php?id=".$row_Recordset2['dataid']."&name=".urlencode($row_Recordset2['name']).">预览</a>";}
	 ?></td>
    </tr>
    <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));}; ?>
</table>

</p>
<p>
<table width="900" border="0" align="center">
  <tr>
    <td bgcolor="#666666"><b>网友评价</b></td>
  </tr>
</table>

<table width="900" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr align="center" valign="middle">
  <td width="80" height="80" >发表<br>评价</td>
  <td ><form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
    <label for="textarea"></label>
    <textarea name="textarea" class="css2" id="textarea" style="float:left"></textarea>
    <input name="button" type="submit" class="css3" id="button" value="评价" />
    <input type="hidden" name="MM_insert" value="form1" />
  </form></td>
  </tr>
</table>
</p>
<p>
<table width="900" border="1" align="center" cellpadding="0" cellspacing="0">
  <?php if($totalRows_Recordset3>0){do { ?>
    <tr align="center" valign="middle">
      <td width="100" height="100"><img src="images/head/<?php echo isset($row_Recordset3['head'])?$row_Recordset3['head']:"unknown"; ?>.gif" width="80" height="80" /><br><?php echo $row_Recordset3['username']; ?></td>
      <td width="700"><?php echo $row_Recordset3['content']; ?></td>
      <td><?php echo $row_Recordset3['time']; ?></td>
    </tr>
    <?php } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));}; ?>
</table>
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php if ($pageNum_Recordset3 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Recordset3=%d%s", $currentPage, 0, $queryString_Recordset3); ?>">第一页&nbsp;&nbsp;</a>
    <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_Recordset3 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Recordset3=%d%s", $currentPage, max(0, $pageNum_Recordset3 - 1), $queryString_Recordset3); ?>">前一页&nbsp;&nbsp;</a>
    <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_Recordset3 < $totalPages_Recordset3) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Recordset3=%d%s", $currentPage, min($totalPages_Recordset3, $pageNum_Recordset3 + 1), $queryString_Recordset3); ?>">下一个&nbsp;&nbsp;</a>
    <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_Recordset3 < $totalPages_Recordset3) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Recordset3=%d%s", $currentPage, $totalPages_Recordset3, $queryString_Recordset3); ?>">最后一页</a>
    <?php } // Show if not last page ?></td>
  </tr>
</table>
</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

?>
