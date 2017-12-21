<?php
include ('../main/header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
require_once ("../../class/upimage.class.php");
protegePagina();
$conn = new Cxoi;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $conn = new Cxoi;
    $status = '';
    $error = 0;
    
    $cd_emp = (isset($_GET['cd']) )? $_GET['cd'] : '';
    $date = (isset($_GET['date']) )? $_GET['date'] : '';
    
    $delete = $conn->sqlQuery('DELETE FROM justifications WHERE dt_just = "'.$date.'" AND cd_emp = '.$cd_emp);
    
    if($delete){
        $status = 'success';
    }
}
?>


<body>
    <?php include('../main/menu.php')
    ?>
    <div id="mainCont">
        <?php 
    if($status == 'success'){
    echo '<div class=\'msg-success\'>
						<img class=\'img\' src=\'../../img/success.png\'>
						<label>Justificativa removida com <b>sucesso</b></label>.
						<a class=\'hrefRepeat\' href=\'../edit/editTime.php?cd='.$cd_emp.'&date='.$date.'\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Continuar no mesmo funcionário.</div>
						</a>
					  </div>';				
} else {
    echo '<div class=\'msg-fail\'>
						<img class=\'img\' src=\'../../img/fail.png\'>
						<label><b>Falha</b> ao remover a justificativa!</label>.
						<a class=\'hrefRepeat\' href=\'../edit/editTime.php?cd='.$cd_emp.'&date='.$date.'\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Tentar novamente.</div>
						</a>
					  </div>';
}
        ?>
    </div>
</body>
</html>