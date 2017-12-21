<?php 
include ('../class/cxoi.class.php');
include ('../class/functions.php');

$store = $_GET['store'];

$conn = new Cxoi;
$emp = $conn->sqlQuery("SELECT *, e.cd_emp FROM employees e LEFT JOIN times t ON t.cd_emp = e.cd_emp AND t.dt_time = '" . date('Y-m-d') . "' WHERE e.cd_emp <> 105  AND e.is_active = 1 AND e.cd_store = $store ORDER BY e.nm_emp 	");

$grey = 0;
 
while($eemp = mysqli_fetch_assoc($emp)){

    include('widget_front_item_template.php');

$grey = ($grey == 1) ? 0 : 1;
}
?>