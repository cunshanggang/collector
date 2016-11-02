<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>新闻页面</title>
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<style type="text/css">
	.page-header,.panel-body{width: 80%;margin:0 auto;}
	.page-header{background:#EBEBEB;text-align: center;line-height:40px;color:#05498b;}
	.panel-body{background:#F8F8FF;height: auto;}
	p{width:80%;margin:0 auto;text-align: center;border-top:1px dashed #D4D4D4;border-bottom: 1px dashed #D4D4D4;color:#696969;}
	.btn-small{margin:auto 50%;width: 50px;height: 25px;}
	</style>
</head>
<body>
	<?php 
	require_once 'conn.php';
	
	$id = $_GET["id"];
	
	$sql ="SELECT * FROM `news` WHERE id=$id"; 
	
	$query = mysql_query($sql);
	
	$result = mysql_fetch_array($query);
	?>
	<div class="page-header">
   		<h3><?php echo iconv("GBK", "UTF-8", $result['title']);?></h3>
	</div>
	<p><?php echo "日期";echo iconv("GBK", "UTF-8", $result['sourceTime']);?></p>
	<div class="panel panel-default">
	   <div class="panel-body">
	   	<?php echo iconv("GBK", "UTF-8", $result['content']);?>
	   </div>
	</div>
		<a href="list.php" class="btn btn-primary btn-small">返回</a>
</body>
</html>