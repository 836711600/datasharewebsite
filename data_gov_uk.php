<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>data.gov检索结果</title>
<style>
a:link, a:visited {color:blue;}
</style>
<?php
class Trans_error
{
	var $dst;
	function __construct($dst="翻译接口调用失败")
	{
		$this->dst=$dst;
	}
}
$max_row_num=10;
$current_page=$_GET["page"];
function translate($value,$api_num=1,$from="auto",$to="auto")
{
  $value_code=urlencode($value);

  $appid="20170324000043296";
  $key='dXfVZpe1nr0bnZY6ek3A';
  $salt='zhangyu';
  $sign=md5($appid.$value.$salt.$key);
  switch($api_num)
  {
	  case 1:$appid="20170324000043296";break;
			  case 2:$appid="20170324000043296";break;
	 		 case 3:$appid="20170324000043296";break;
	 		 case 4:$appid="20170324000043296";break;
	 		 case 5:$appid="20170324000043296";break;
			  case 6:$appid="20170324000043296";break;
	 		 case 7:$appid="20170324000043296";break;
	 		 case 8:$appid="20170324000043296";break;
	 		 case 9:$appid="20170324000043296";break;
	 		 case 10:$appid="20170324000043296";break;
			  default:$appid="20170324000043296";
  }

  $languageurl = "http://api.fanyi.baidu.com/api/trans/vip/translate?appid=" . $appid ."&q=" .$value_code. "&from=".$from."&to=".$to."&salt=".$salt."&sign=".$sign;

  $i=0;
  do
  {
  	$text=json_decode(read_url($languageurl));
	$i++;
  }
  while((!isset($text->trans_result))&&$i<2);
  $i=0;
  if(isset($text->trans_result))
  {
  	$text = $text->trans_result;
  	return $text;
  }
  else
  {
	 return array(new Trans_error("翻译接口调用失败"),new Trans_error("翻译接口调用失败"),new Trans_error("翻译接口调用失败")); 
  }
}

function multi_translate($value,$num,$from="auto",$to="auto")
{
	for($i=0;$i<$num;$i++)
	{
  		$value_code[$i]=urlencode($value[$i]);
	}
	$appid="20170324000043296";
  $key='dXfVZpe1nr0bnZY6ek3A';
  $salt='zhangyu';
  $sign=md5($appid.$value.$salt.$key);
		for($i=0;$i<$num;$i++)
	{
  		  $appid="";
  			switch($i)
 			 {
			  case 1:$appid="20170324000043296";break;
			  case 2:$appid="20170324000043296";break;
	 		 case 3:$appid="20170324000043296";break;
	 		 case 4:$appid="20170324000043296";break;
	 		 case 5:$appid="20170324000043296";break;
			  case 6:$appid="20170324000043296";break;
	 		 case 7:$appid="20170324000043296";break;
	 		 case 8:$appid="20170324000043296";break;
	 		 case 9:$appid="20170324000043296";break;
	 		 case 10:$appid="20170324000043296";break;
			  default:$appid="20170324000043296";
  			}

  $languageurl = "http://api.fanyi.baidu.com/api/trans/vip/translate?appid=" . $appid ."&q=" .$value_code[$i]. "&from=".$from."&to=".$to."&salt=".$salt."&sign=".$sign;
			 $translate_url[$i]=$languageurl;
	}
	
	$mh = curl_multi_init();   
	for($i=0;$i<$num;$i++)
	 {
  		$conn[$i] = curl_init($translate_url[$i]);   
  		curl_setopt($conn[$i], CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)");   
  		curl_setopt($conn[$i], CURLOPT_HEADER ,0);   
 		 curl_setopt($conn[$i], CURLOPT_CONNECTTIMEOUT,60);   
 		 curl_setopt($conn[$i],CURLOPT_RETURNTRANSFER,true);  // 设置不将爬取代码写到浏览器，而是转化为字符串   
 		 curl_multi_add_handle ($mh,$conn[$i]);   
	}
	do {   
  		curl_multi_exec($mh,$active);   
		} while ($active);
	for($i=0;$i<$num;$i++)
	{
  		 $data[$i] = curl_multi_getcontent($conn[$i]);
	}
	for($i=0;$i<$num;$i++)
	{
  		curl_multi_remove_handle($mh,$conn[$i]);   
		curl_close($conn[$i]); 
	}
	curl_multi_close($mh);
	for($i=0;$i<$num;$i++)
	{
		$text[$i]=json_decode($data[$i]);
  		if(isset($text[$i]->trans_result))
		{
			$text[$i]=$text[$i]->trans_result;
		}
		else {$text[$i]=translate($value[$i]);}
	}
	return $text;
}

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
for($i=0;$i<$row_num;$i++)
{
	$english[$i]="";
	$english[$i]=($english[$i]).$result[$i]->title;
	$english[$i]=($english[$i])."\n";
	$english[$i]=($english[$i]).$result[$i]->organization->title;
	$english[$i]=($english[$i])."\n";
	$english[$i]=($english[$i]).$result[$i]->notes;
}
	$translate_result=multi_translate($english,$row_num);
	for($i=0;$i<$row_num;$i++)
{
	$chinese[$i*3]=$translate_result[$i][0];
	$chinese[$i*3+1]=$translate_result[$i][1];
	$chinese[$i*3+2]=$translate_result[$i][2];
}

$html="";
for($i=0;$i<$row_num;$i++)
{
	$html.="<a href=\"http://data.gov.uk/dataset/".$result[$i]->name."\" target=\"_blank\"><h3>".($i+1).".".$chinese[$i*3]->dst."</h3></a><p><b>来源：</b>".$chinese[$i*3+1]->dst."<br><b>描述：</b>".$chinese[$i*3+2]->dst."<br><b>数据格式：</b>";
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
$html.="<a href=\"data_gov_uk.php?keyword=".$_GET["keyword"]."&page=1\">首页</a>&nbsp;";
if($current_page>1)
{
	$html.="<a href=\"data_gov_uk.php?keyword=".$_GET["keyword"]."&page=".($current_page-1)."\"><前一页</a>&nbsp;";
}
for($j=0;$j<10&&(($i+$j)<=$total_page);$j++)
{
	if(($i+$j)==$current_page)
	{
		$html.=($i+$j)."&nbsp;";
	}
	else
	{ 
		$html.="<a href=\"data_gov_uk.php?keyword=".$_GET["keyword"]."&page=".($i+$j)."\">".($i+$j)."</a>&nbsp;";	
	}
}
if($current_page<$total_page)
{
	$html.="<a href=\"data_gov_uk.php?keyword=".$_GET["keyword"]."&page=".($current_page+1)."\">后一页></a>&nbsp;";
}
$html.="<a href=\"data_gov_uk.php?keyword=".$_GET["keyword"]."&page=".$total_page."\">末页</a>&nbsp;";
$html.="共".$total_page."页";
$html.="</h2>";
echo $html;
?>
</body>
</html>