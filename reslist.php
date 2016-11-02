<?php 	session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>采集结果列表</title>
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<style type="text/css">
	p{text-align: center;font-size: 20px;}
	.table-bordered{width: 80%;height:auto;margin:0 auto;text-align: center;}
	table tr:nth-child(odd){background:#87CEFF;}
	table tr:nth-child(even){background:#FAFAD2;}
	table tr:hover{background:#FFD700;}
	.form-inline{margin-left: 50%;}
	</style>
	<script type="text/javascript">
		function check(form) {
			var valStart = document.getElementById("start").value;
			var valEnd = document.getElementById("end").value;
			//验证输入的合法性，只能是数字且开始的要比结束的数小
			if(valStart!="" || valEnd!="") {
					if(!(/^\d+$/.test(valStart)) || !(/^\d+$/.test(valEnd)) || parseInt(valStart)>parseInt(valEnd)) {
						alert("请正确输入!");
						form.start.focus();
						return false;//返回值后不正确表单不刷新
						}
			 } else {
				 alert("请正确输入!");
				 form.start.focus();
				 return false;
				 }
			}
	</script>
</head>
<body>
    <?php
	//header('Content-type:text/html;charset=utf8;'); 
    error_reporting(0);

	
	//引入数据库
	require_once 'conn.php';
	//获取远程网页的内容
	$str=file_get_contents("http://www.csust.edu.cn/pub/xww/xsdt/");
	//匹配“新闻标题跟链接”
	$preg = '/<li><span>(.*?)<\/span><a href="(.*?)">(.*?)<\/a><\/li>/';
	//将获取到的内容转换为数组
	preg_match_all($preg, $str, $arr);
	//计算总条数
	$total = count($arr[2]);
	
	$_SESSION['end2'] = $_GET['end'];
	//echo $_SESSION['end2'];
	?>
	<p class="text-success">结果列表:共<?php echo $total;?>条</p>
	<div class="progress progress-striped active">
		<div class="bar bar-info" style="width: 100%;"></div>
	</div>
	<form class="form-inline" method="get" action="into.php">
		<span class="label label-warning">采集的条件:</span>
		<span class="label label-info">第</span>
		<input type="text" class="input-small" name="id" id="start" style="width:22px;">
		<span class="label label-info">条</span>
		<span class="label label-info">TO</span>
		<span class="label label-info">第</span>
		<input type="text" class="input-small" name="end" id="end" style="width:37px;" >
		<span class="label label-info">条</span>
		<button type="submit" class="btn btn-success" onclick="return check(this.form)">确定</button>
	</form>
    <div class="progress progress-striped active">
		<div class="bar bar-success" style="width: 100%;"></div>
	</div>
	<table class="table-bordered">
			<?php
			//相同的部分地址
			$url = "http://www.csust.edu.cn/pub/xww/xsdt/";
				foreach($arr[2] as $k=>$v) {
				    $title = $arr[3][$k];
					echo "<tr><td><span class='badge badge'>";
					echo $k+1;
					echo "</span></td>";
					echo "<td>";
					//将GBK格式强制转换成UTF-8
					echo iconv('GBK', 'UTF-8', $arr[3][$k]);
					//如果不转换的话会出现乱码，可以按如下输出
					//echo $arr[3][$k];
					echo "</td></tr>";
					//入库
					$sql = "INSERT INTO `tmp_url` (`title`,`url`) VALUES ('$title','$url".$v."')";
					mysql_query($sql);
				}
			?>
	</table>
</body>
</html>