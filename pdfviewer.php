<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/pdfobject.js"></script>
       
	<script type="text/javascript">
	window.onload = function(){
		var dir="files/<?php echo $_GET['id'].'/'.$_GET['name']; ?>";
		var myPDF = new PDFObject({ url: dir }).embed();
		document.getElementById("obj").style.display="";
     }
    </script>
<title>在线预览</title>
</head>

<body style="overflow-x:hidden;overflow-y:auto;">
<object style="display: none;" id="obj" height="650" width="100%" border="0"  classid="clsid:ca8a9780-280d-11cf-a24d-444553540000">
           <param name="_version" value="65539">  
           <param name="_extentx" value="20108">  
           <param name="_extenty" value="10866">  
           <param name="_stockprops" value="0">  
           <param name="src" value="files/<?php echo $_GET['id'].'/'.urlencode($_GET['name']); ?>";> 
</object>
</body>
</html>