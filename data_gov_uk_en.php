<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>data.gov.uk检索结果</title>
<style>
a:link, a:visited {color:blue;}
</style>
<?php
set_time_limit(1000);
$max_row_num=10;
$current_page=$_GET["page"];


function read_url($url)  #获取目标URL所打印的内容
{
  $url=str_replace(' ','%20',$url);
  if(function_exists('file_get_contents')) {
   $file_contents = file_get_contents($url,false,stream_context_create(array('http'=>array('methed'=>"GET",'timeout'=>60))));
  } else {
  $ch = curl_init();
  $timeout = 5;
  curl_setopt ($ch, CURLOPT_URL, $url);
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $file_contents = curl_exec($ch);
  curl_close($ch);
  }
   return $file_contents;
}
function get_result($keyword,$page)
{
	$max_row_num=10;
	$url="http://data.gov.uk/api/3/action/package_search?q=".$keyword."&start=".($max_row_num*$page)."&rows=".$max_row_num;
	return json_decode(read_url($url))->result;
}
 ?>
</head>

<body>
<?php 
$result=get_result($_GET["keyword"],$current_page-1);
if(empty($result->count))
{
	echo "无相关结果";
	die(0);
}
$total_page=(int)(($result->count-1)/$max_row_num)+1;
$row_num=0;

if($result->count==0)
{
		$row_num=0;	
}
if($current_page<$total_page)
{
		$row_num=$max_row_num;
}
else if($result->count%$max_row_num==0)
{
		$row_num=$max_row_num;
}
else $row_num=$result->count%$max_row_num;

echo "<h3>找到相关结果".$result->count."条：</h3>";

$result=$result->results;

$html="";
for($i=0;$i<$row_num;$i++)
{
	$html.="<a href=\"http://data.gov.uk/dataset/".$result[$i]->name."\" target=\"_blank\"><h3>".($i+1).".".$result[$i]->title."</h3></a><p><b>来源：</b>".$result[$i]->organization->title."<br><b>描述：</b>".$result[$i]->notes."<br><b>数据格式：</b>";
	for($j=0;$j<$result[$i]->num_resources;$j++)
	{
		$html.="<a href=\"".$result[$i]->resources[$j]->url."\" target=\"_blank\">".(empty($result[$i]->resources[$j]->format)?"unknown":$result[$i]->resources[$j]->format)."</a>";
		if($j<($result[$i]->num_resources-1))
		$html.="|";	
	}
	$html.="</p>";	
}
if($current_page>4)
{
	$i=$current_page-4;
}
else $i=1;
$html.="<h2>";
$html.="<a href=\"data_gov_uk_en.php?keyword=".$_GET["keyword"]."&page=1\">首页</a>&nbsp;";
if($current_page>1)
{
	$html.="<a href=\"data_gov_uk_en.php?keyword=".$_GET["keyword"]."&page=".($current_page-1)."\"><前一页</a>&nbsp;";
}
for($j=0;$j<10&&(($i+$j)<=$total_page);$j++)
{
	if(($i+$j)==$current_page)
	{
		$html.=($i+$j)."&nbsp;";
	}
	else
	{ 
		$html.="<a href=\"data_gov_uk_en.php?keyword=".$_GET["keyword"]."&page=".($i+$j)."\">".($i+$j)."</a>&nbsp;";	
	}
}
if($current_page<$total_page)
{
	$html.="<a href=\"data_gov_uk_en.php?keyword=".$_GET["keyword"]."&page=".($current_page+1)."\">后一页></a>&nbsp;";
}
$html.="<a href=\"data_gov_uk_en.php?keyword=".$_GET["keyword"]."&page=".$total_page."\">末页</a>&nbsp;";
$html.="共".$total_page."页";
$html.="</h2>";
echo $html;
?>
</body>
</html>