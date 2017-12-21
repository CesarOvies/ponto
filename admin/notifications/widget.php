<?php
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');

$conn = new Cxoi;
$dof = strtolower(date('D'));
$time = date("H:i:s");
$which_store = 0;


$select_store = ($_GET['store']) ? ($_GET['store']) : '0';
$input_miss = ($_GET['miss']);
$input_late = ($_GET['late']);
$input_dayoff = ($_GET['dayoff']);
$input_ontime = ($_GET['ontime']);

$sqlMiss = ($input_miss == 0) ? " AND NOT (t.tm_entry IS NULL AND tu.entry_" . $dof . " < '" . $time . "')  " : '  ';
$sqlLate = ($input_late == 0) ? " AND NOT (t.tm_entry IS NOT NULL AND tu.entry_" . $dof . " < t.tm_entry)  " : '  ';
$sqlOntime = ($input_ontime == 0) ? " AND NOT (t.tm_entry IS NOT NULL AND tu.entry_" . $dof . " > t.tm_entry)  " : '  ';
$sqlStore = ($select_store != 0) ? ' AND e.cd_store = ' . $select_store : '  ';


$sqlWidget = "
SELECT *, e.cd_emp 
FROM employees e 
LEFT JOIN times t ON t.cd_emp = e.cd_emp AND t.dt_time = '" . date('Y-m-d') . "' 
JOIN turns tu ON tu.cd_turn = e.cd_turno 
JOIN stores s ON s.cd_store = e.cd_store 
LEFT JOIN justifications j ON j.dt_just = '" . date('Y-m-d') . "' AND e.cd_emp = j.cd_emp
WHERE e.cd_emp <> 105  AND e.is_active = 1 ". $sqlStore . $sqlMiss . $sqlLate . $sqlOntime . "
ORDER BY e.cd_store, t.tm_entry DESC, e.nm_emp 	
";
$emp = $conn -> sqlQuery($sqlWidget);


while ($eemp = mysqli_fetch_assoc($emp)) {
    if($eemp['cd_store'] != $which_store){
        echo "<div class='widget_store' id='store_" . $eemp['cd_store'] . "'>". $eemp['nm_store'] ."</div>";
        $which_store = $eemp['cd_store'];
    }
    
    
    
   
        include('widget_item_template.php');
    
} ?>

