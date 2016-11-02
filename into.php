<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>采集入库...</title>
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<style type="text/css">
	.panel{background:#EAEAEA;width:80%;margin:0 auto;}
	.panel-heading,.panel-body,.panel-sourceTime{width:80%;;margin:0 auto;}
	.panel-body{background:#00F5FF;height:auto;}
	.panel-heading{background:#F0FFFF;text-align:center;}
	 h3{white-space:nowrap;text-overflow:ellipsis;-o-text-overflow:ellipsis;overflow:hidden;}
	.panel-heading,.panel-sourceTime,.panel-body{margin-top:-9px;}
	.panel-sourceTime{background:#B0E2FF;text-align:center;}
	/*.badge-info{border:5px solid;border-radius:10px;}*/
	</style>
</head>
<body>
		<div class="progress progress-striped active" style="width:80%;height:auto;margin:0 auto;">
			<div class="bar" style="width: 50%;">正在采集入库...</div>
			<div class="bar bar-success" style="width: 50%;">请稍等...</div>
		</div>
		<?php 
		require_once 'conn.php';
		$_SESSION['start1'] = isset($_GET["id"])?$_GET["id"]:$_SESSION["start1"];
		$_SESSION['end1'] = isset($_GET["end"])?$_GET["end"]:$_SESSION['end1'];
		$id  = $_GET['id'];
		$sql = "SELECT * FROM `tmp_url` WHERE id=$id";
		//echo $sql;
		$query = mysql_query($sql);
		
		while ($result = mysql_fetch_array($query)) {
			//标题
			$title = $result['title'];
			//地址
			$url = $result['url'];
			//匹配时间
			$con = file_get_contents($url);
			$preg_time = '/<span>(.*?)<\/span>/';
			preg_match_all($preg_time, $con, $arr1);
			$sourceTime = $arr1[0][0].$arr1[0][1];
			//匹配内容
			$preg_con = '/<div class="tit-content">[\s\S]+<!-- tit-content -->/';
			preg_match_all($preg_con, $con, $arr2);
			$content = strip_tags($arr2[0][0]);
		}
		//入库
		$sql3 = "INSERT INTO `news` (`id`, `title`, `sourceTime`, `content`) VALUES (NULL, '$title', '$sourceTime', '$content')";
		mysql_query($sql3);
		
		$sql2 = "SELECT * FROM `tmp_url` WHERE id>'$id' ORDER BY id ASC LIMIT 1";
		$query1 = mysql_query($sql2);
		$result2 = mysql_fetch_array($query1);
		//echo $result2['id'];
		?>
		<div class="panel panel-default">
			<div class="panel-heading">
      			<h3 class="panel-title"><span class="badge badge-info"><?php echo $id;?></span><?php echo iconv('GBK', 'UTF-8', $title);?></h3>
   			</div>
   			<div class="panel-sourceTime">
      			<h5><?php echo "日期：";echo iconv('GBK', 'UTF-8', $sourceTime);?></h5>
   			</div>
   			<div class="panel-body">
     		 <?php echo iconv('GBK','UTF-8', $content);?>
   			</div>
		</div>
		<?php
		$start1 = $_SESSION['start1'];
		$end1 = $_SESSION['end1'];//$result2['id']>=$start1 && 
		if ($result2['id']<=$end1) {//$result2['id']>$start1 &&
			echo "<script>location.href='into.php?id={$result2['id']}'</script>";
		} else {
			echo "<script>alert('采集结束!');location.href='list.php'</script>";
		}
		?>
</body>
</html>