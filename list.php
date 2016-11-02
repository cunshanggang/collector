<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>入库结果列表</title>
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<style type="text/css">
	.table-bordered{width: 80%;height:auto;margin:0 auto;text-align: center;}
	table tr:nth-child(odd){background:#F0FFFF;}
	table tr:nth-child(even){background:#F0F0F0;}
	table tr:hover{background-color:#EEEE00;}
	.label{color:#08c;}
	</style>
	<script type="text/javascript">
	//确定删除
	$(function(){
		var aa;
		$('#myTable').on('click','.delete',function(){
			aa = $(this).attr('href');
		});
		
		$('#sureDelete').click(function(){
			window.location = aa;
		});
		
	})
	</script>
</head>
<body>
	<?php 
	require_once 'conn.php';
	//显示每页10条信息
	$pagesize = 10;
	//获取当前页面地址
	$url = $_SERVER['REQUE_URI'];
	//解析一个URL并返回一个关联数组，如果一个URL不完整，也可以被接受，parse_url()会尝试正确地将它解析
	$url = parse_url($url);
	//将关联数组中‘path’赋值给$URL;
	$url = $url['path'];
	
	if (!empty($_GET["page"])) {
		$pageval = $_GET["page"];
		$page = ($pageval-1)*$pagesize;
		$page.=',';
	}
	
	//查询
	$sql1 = "SELECT * FROM `news` ORDER BY id ASC LIMIT $page $pagesize";
	$query1 = mysql_query($sql1);
	
	//查找总条数
	$sql = "SELECT * FROM `news` ";
	$query = mysql_query($sql);
	$total = mysql_num_rows($query);
	
	//获取分页数，总条数除以每页显示的余数用进一取整函数ceil()
	$count_page = ceil($total/$pagesize);
	?>
	<table id="myTable" class="table-bordered">
	<?php 
		while($result = mysql_fetch_array($query1)){
	//$result['id'];
		echo "<tr><td><span class='badge badge'>";
		echo $result['id'];
		echo "</span></td>";
		echo "<td><a href='view.php?id={$result['id']}' class='btn btn-link'>";
		echo iconv("GBK","UTF-8",$result[title]);
		echo "</a></td>";
		echo '<td style="width:12%;">';
		echo "<a href='view.php?id={$result['id']}' class='btn btn-info'>";
		echo "查看";
		echo "</a>";
		echo "<a class='delete' href='delete.php?id={$result['id']}'><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#myModal'>";
		echo "删除";
		echo "</button></a></td></tr>";
	}
	//class="btn btn-primary" data-toggle="modal"
	//<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button
	?>
	</table>
	<div class="pagination pagination-centered">
		<ul>
			<?php 
			for ($i=1;$i<=$count_page;$i++) {
				echo "<li>";
				echo "<a href=$url?page=$i>&nbsp;$i&nbsp;</a></li>";
			}
			echo "<li><span class='label'>共{$count_page}页</span></li>";
			?>
			<li><span class="label">总<?php echo $total;?>条</span></li>
		</ul>
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body text-center">
     		   确定删除吗?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary" id="sureDelete">确定</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>