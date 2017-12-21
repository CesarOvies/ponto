<?php
ini_set ( "memory_limit", "128M");
include ('../main/header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
require_once ("../../class/upimage.class.php");
protegePagina();
$conn = new Cxoi;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new Cxoi;
    $status = '';
    $r = $_POST;
    $error = 0;
    if(isset($r['inputType'])){
        $sqlvalues = '';
        $sqldata = '';
        $cd_emp = (isset($_POST['inputCdEmp'])) ? $_POST['inputCdEmp'] : '';
        $date = (isset($_POST['inputDate'])) ? $_POST['inputDate'] : '';
        $type = (isset($_POST['inputType'])) ? $_POST['inputType'] : '';
        
        $checkJust = $conn->numRows('SELECT * FROM justifications WHERE cd_emp = '.$cd_emp.' AND dt_just = "'.$date.'"');
        
        if ($type == 'medic' || $type == 'declaration' || $type == 'medicday') {

            $dir = '../../justifications/';
            $max_size = 1024 * 1024 * 10;
            $ext = ['jpg', 'png', 'pdf', 'gif'];

            if ($_FILES['inputJustificationFile']['error'] != 0) {
                $error++;
            }

            $extension = explode('.', $_FILES['inputJustificationFile']['name']);
            $extension = strtolower(end($extension));
            if (array_search($extension, $ext) === false) {
                $error++;
            }

            if ($max_size < $_FILES['inputJustificationFile']['size']) {
                $error++;
            }

            $finalname = str_replace(' ', '', strtolower($date . '_' . $cd_emp . '.' . $extension));
            if (move_uploaded_file($_FILES['inputJustificationFile']['tmp_name'], $dir . $finalname)) {
                echo 'ok';
            }
        }
        
        if($checkJust != 0){
            
            $sqlupdate = ' ds_just = null, ds_file = null, tm_begin = null, tm_end = null ';
                
            if($type == 'other'){
                $sqlupdate = ' ds_just = "'.$_POST['inputDescriptJustification'].'", ds_file = null, tm_begin = null, tm_end = null';
            }
            if($type == 'medic'){
                $sqlupdate = ' ds_just = null , ds_file = "'.$finalname.'", tm_begin = "'.$_POST['inputJustificationBegin'].'", tm_end = "'.$_POST['inputJustificationEnd'].'"';
            }
            if($type == 'declaration'){
                $sqlupdate = ' ds_just = null , ds_file = "'.$finalname.'", tm_begin = null, tm_end = null';
            }
            if($type == 'medicday'){
                $sqlupdate = ' ds_just = null , ds_file = "'.$finalname.'", tm_begin = null, tm_end = null';
            }
            
            $update = $conn->sqlQuery('UPDATE justifications SET tp_just ="'.$type.'"  ,'.$sqlupdate.', cd_manager = 0 WHERE cd_emp = '.$cd_emp.' AND dt_just = "'.$date.'"');
            if($update){
                $status = 'updatesuccess';
            }
        }else{
            $check = $conn->numRows('SELECT * FROM times WHERE cd_emp = '.$cd_emp.' AND dt_time = "'.$date.'"');
            if($check == 0){
                $createTimesDay = $conn->sqlQuery('INSERT INTO times (dt_time, cd_emp) values ("'.$date.'","'.$cd_emp.'")');    
            }
    
            if($type == 'other'){
                $sqlvalues = ', ds_just ';
                $sqldata = ", '".$_POST['inputDescriptJustification']."'";
            }
            if($type == 'medic'){
                $sqlvalues = ', ds_file, tm_begin, tm_end ';
                $sqldata = ", '".$finalname."', '".$_POST['inputJustificationBegin']."', '".$_POST['inputJustificationEnd']."'";
            }
            if($type == 'declaration'){
                $sqlvalues = ', ds_file ';
                $sqldata = ", '".$finalname."' ";
            }
            if($type == 'medicday'){
                $sqlvalues = ', ds_file ';
                $sqldata = ", '".$finalname."' ";
            }

            $insert = $conn->sqlQuery('INSERT INTO justifications (dt_just, tp_just, cd_emp, cd_manager '.$sqlvalues.') values ("'.$date.'","'.$type.'","'.$cd_emp.'", "0" '.$sqldata.')');
            if($insert && $error == 0){
                $status = 'success';
            }  
        }
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
						<label>Justificativa adicionada com <b>sucesso</b></label>.
						<a class=\'hrefRepeat\' href=\'../edit/editTime.php?cd='.$cd_emp.'&date='.$date.'\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Continuar no mesmo funcionário.</div>
						</a>
					  </div>';				
} else if($status == 'updatesuccess'){
    echo '<div class=\'msg-success\'>
						<img class=\'img\' src=\'../../img/success.png\'>
						<label>Justificativa editada com <b>sucesso</b></label>.
						<a class=\'hrefRepeat\' href=\'../edit/editTime.php?cd='.$cd_emp.'&date='.$date.'\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Continuar no mesmo funcionário.</div>
						</a>
					  </div>';				
} else {
    echo '<div class=\'msg-fail\'>
						<img class=\'img\' src=\'../../img/fail.png\'>
						<label><b>Falha</b> ao adicionar a justificativa!</label>.
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