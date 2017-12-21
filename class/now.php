<?php 

$t = explode(" ",microtime());
$return['now'] =  date("H:i:s",$t[1]).substr((string)$t[0],1,4);

$return['time'] =  date("H:i:s");

$return['dof'] = date('w');

$return['date'] = date('Y-m-d');
$return['dateBr'] = date('d/m/Y');

echo json_encode($return);
?>
