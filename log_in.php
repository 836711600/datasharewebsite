<?php require_once('Connections/enjoydata.php'); ?>
<?php
error_reporting(E_ALL^E_NOTICE);
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "class";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "log_in.php?msg=用户名或密码错误";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_enjoydata, $enjoydata);
  	
  $LoginRS__query=sprintf("SELECT username, password, class FROM user_reg WHERE username=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $enjoydata) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'class');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户登录</title>
<style type="text/css">
.css1 {	font-size: 36px;
	color: #999;
}
#a1 {	vertical-align: bottom;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
</style>
</head>

<body>
<table width="900" border="0" align="center">
  <tr>
    <td height="60"><a href="index.php" target="_self"><img src="images/title.png" alt="我爱购" name="a1" width="230" height="60" id="a1" /></a>&nbsp; &nbsp; &nbsp; <span class="css1">用户登录</span></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="900" border="0" align="center">
  <tr>
    <td width="450" height="200" align="right"><img src="images/log_in.png" width="300" height="200" /></td>
    <td><table width="300" border="0">
      <tr>
        <td height="60" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="30" align="center">EnjoyData用户登录</td>
      </tr>
      <tr>
        <td height="120"><form ACTION="<?php echo $loginFormAction; ?>" id="form1" name="form1" method="POST">
          <table width="100%" border="0">
            <tr>
              <td width="100" height="30" align="right">用户名</td>
              <td width="200" height="30"><label for="textfield5"></label>
                <input name="username" type="text" id="textfield5" size="20" /></td>
            </tr>
            <tr>
              <td height="30" align="right">密码</td>
              <td height="30"><label for="textfield6"></label>
                <input name="password" type="password" id="textfield6" size="20" /></td>
            </tr>
            <tr>
              <td height="30">&nbsp;&nbsp;&nbsp;</td>
              <td height="30"><input type="submit" name="button" id="button" value="登录" />
                &nbsp;&nbsp;&nbsp;
<input type="reset" name="button2" id="button2" value="重填" /></td>
              </tr>
            <tr>
              <td height="20"></td>
              <td height="20"><font color="#FF0000"><?php echo $_GET['msg']; ?></font></td>
            </tr>
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<hr width="900" align="center" />
<table width="900" border="0" align="center">
  <tr align="right">
    <td>Powered By EnjoyData</td>
  </tr>
</table>
</body>
</html>