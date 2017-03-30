<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
.css1 {	color: #FFF;
}
.css11 {font-size: 36px;
	color: #999;
}
.css11 {	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
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
<table width="900" border="0" align="center">
  <tr>
    <td width="400" height="50" align="right"><img src="images/regok.png" width="50" height="50" /></td>
    <td width="493">恭喜您，订单添加成功！</td>
  </tr>
  <tr>
    <td colspan="2" align="center">现在你可以：</td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="24" colspan="2" align="center">1.<a href="myspace1.php">查看订单</a></td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="2" align="center">2.<a href="data.php?id=<?php echo $_GET['goodsid']; ?>">返回继续购物</a></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>