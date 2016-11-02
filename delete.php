<?php
require_once 'conn.php';

$id = $_GET["id"];
$sql = "DELETE FROM `news` WHERE id=$id";
$query = mysql_query($sql);

echo "<script>location.href='list.php';</script>";
//https://github.com/GitHubOverlord/BookTransaction.git