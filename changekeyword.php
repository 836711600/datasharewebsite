<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>更换检索词</title>
</head>

<body>
外网检索：<a target="_blank" href="data_gov.php?keyword=<?php echo $_POST['keyword']; ?>&page=1">Data.gov（中文）</a>&nbsp;&nbsp;<a target="_blank" href="data_gov_en.php?keyword=<?php echo $_POST['keyword']; ?>&page=1">Data.gov（英文）</a>&nbsp;&nbsp;<a target="_blank" href="data_gov_uk.php?keyword=<?php echo $_POST['keyword']; ?>&page=1">Data.gov.uk（中文）</a>&nbsp;&nbsp;<a target="_blank" href="data_gov_uk_en.php?keyword=<?php echo $_POST['keyword']; ?>&page=1">Data.gov.uk（英文）</a>&nbsp;&nbsp;检索词：<?php echo $_POST['keyword']; ?>
</body>
</html>