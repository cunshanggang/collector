<?php
// function getE($res){
// 	$a=rand(0,49);
// 	if(in_array($a,$res)){
// 		$a=getE($res);
// 	}
// 	array_push($a,$res);
// 	return $res;
// }

// $b = getE(0);
// echo $b;
$com=array();

function getE($res){
	$a=rand(0,49);
	if(in_array($a,$res)){
		$a=getE($res);
	}
	return $a;
}
for($i=0;$i<50;$i++){
	array_push($com,getE($com));
}
echo "<pre>";
print_r($com);
echo "</pre>";
