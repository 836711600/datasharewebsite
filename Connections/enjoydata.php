<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_enjoydata = "localhost";
$database_enjoydata = "enjoydata";
$username_enjoydata = "root";
$password_enjoydata = "zhangyu1994";
$enjoydata = mysql_pconnect($hostname_enjoydata, $username_enjoydata, $password_enjoydata) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES 'UTF8'");
?>