<?php
//header("Content-Type:text/html;charset=utf8");
//header("Content-type: text/html; charset=utf-8");
class mysql{
	private $host;
	private $root;
	private $pwd;
	//private $conn;
	private $dbname;
	
	function __construct($host,$root,$pwd,$dbname) {
		$this->host = $host;
		$this->root = $root;
		$this->pwd = $pwd;
		$this->dbname = $dbname;
		$this->connect();
	}
	
	private function connect() {
	$conn = @mysql_connect($this->host,$this->root,$this->pwd) or die("Mysql连接失败");
	$db = @mysql_select_db($this->dbname,$conn) or die("数据库连接失败");
	$unicode = mysql_query("set names 'GBK'");
	//mysql_query("set names 'utf8'");
	}
	
}

new mysql("localhost","root","","collector");