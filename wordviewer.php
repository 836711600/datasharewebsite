<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线预览</title>
<script language=javascript>
	window.onload=function saveword()
	{
		var dir="C://PHPnow-1.5.6/htdocs/files/<?php echo $_GET['id'].'/'.$_GET['name']; ?>";;
		var oWordApp=new ActiveXObject("Word.Application");
		var oDocument=oWordApp.Documents.Open(dir);
		oDocument.SaveAs("temp.html", 8)
		oWordApp.Quit();
		window.location.href="C://PHPnow-1.5.6/htdocs/temp.html";
	}
</script>
</head>

<body>
</body>
</html>