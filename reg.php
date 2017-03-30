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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="reg.php?msg=用户名已存在";
  $loginUsername = $_POST['username'];
  $LoginRS__query = sprintf("SELECT username FROM user_reg WHERE username=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_enjoydata, $enjoydata);
  $LoginRS=mysql_query($LoginRS__query, $enjoydata) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO user_reg (username, password, useradd, email, usertel) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['useradd'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['usertel'], "text"));

  mysql_select_db($database_enjoydata, $enjoydata);
  $Result1 = mysql_query($insertSQL, $enjoydata) or die(mysql_error());

  $insertGoTo = "regok.php";
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
<title>新用户注册</title>
<style type="text/css">
#a1 {
	vertical-align: bottom;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
.css1 {
	font-size: 36px;
	color: #999;
}
</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
</head>

<body>
<table width="900" border="0" align="center">
  <tr>
    <td height="60"><a href="index.php" target="_self"><img src="images/title.png" alt="我爱购" name="a1" width="230" height="60" id="a1" /></a>&nbsp; &nbsp; &nbsp; <span class="css1">账户注册</span></td>
  </tr>
</table>
<p>&nbsp;</p>
  <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
    <table width="900" border="0" align="center">
      <tr>
        <td width="300" height="200" rowspan="8"><img src="images/reg.png" alt="" width="300" height="200" /></td>
        <td colspan="2" align="center">EnjoyData用户注册（带<font color="#FF0000">*</font>为必填项）&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td align="right">用户名&nbsp; &nbsp;&nbsp; </td>
        <td><label for="username"></label>
          <span id="sprytextfield1">
          <input type="text" name="username" id="username" />
        <span class="textfieldRequiredMsg">需要提供一个值。</span><span class="textfieldMinCharsMsg">不符合最小字符数要求。</span><span class="textfieldMaxCharsMsg">已超过最大字符数。</span></span><font color="#FF0000">*</font>(2~10个字符)<font color="#FF0000"><?php echo $_GET['msg']; ?></td>
      </tr>
      <tr>
        <td align="right">密码&nbsp; &nbsp;&nbsp; </td>
        <td><span id="sprypassword1">
        <input type="password" name="password" id="password" />
        <span class="passwordRequiredMsg">需要输入一个值。</span><span class="passwordMinCharsMsg">不符合最小字符数要求。</span><span class="passwordMaxCharsMsg">已超过最大字符数。</span><span class="passwordInvalidStrengthMsg">密码必须包含字母和数字</span></span><font color="#FF0000">*</font>（6~20个字符，必须包含字母和数字）</td>
      </tr>
      <tr>
        <td align="right">确认密码&nbsp; &nbsp;&nbsp; </td>
        <td><span id="spryconfirm1">
          <input type="password" name="password2" id="password2" />
        <span class="confirmRequiredMsg">需要输入一个值。</span><span class="confirmInvalidMsg">与原密码不同</span></span><font color="#FF0000">*</font></td>
      </tr>
      <tr>
        <td align="right">地址&nbsp; &nbsp;&nbsp; </td>
        <td><input type="text" name="useradd" id="useradd" /></td>
      </tr>
      <tr>
        <td align="right">邮箱&nbsp; &nbsp;&nbsp; </td>
        <td><span id="sprytextfield2">
        <input type="text" name="email" id="email" />
<span class="textfieldInvalidFormatMsg">格式无效。</span></span></td>
      </tr>
      <tr>
        <td align="right">电话&nbsp; &nbsp;&nbsp; </td>
        <td><span id="sprytextfield3">
        <input type="text" name="usertel" id="usertel" />
<span class="textfieldInvalidFormatMsg">格式无效。</span></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="button" id="button" value="注册" />
          &nbsp;&nbsp;
          <input type="reset" name="button2" id="button2" value="重填" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
</form>
<p>&nbsp;</p>
<hr width="900" align="center" />
<table width="900" border="0" align="center">
  <tr align="right">
    <td>Powered By EnjoyData</td>
  </tr>
</table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:2, maxChars:10, validateOn:["blur"]});
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {minChars:6, maxChars:20, validateOn:["blur"], minAlphaChars:1, minNumbers:1});
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "password", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email", {validateOn:["blur"], isRequired:false});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["blur"], isRequired:false});
</script>
</body>
</html>