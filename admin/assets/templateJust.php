<?php 
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
require_once ('../class/emonth.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new Cxoi;
    
    $r = (isset($_POST)) ? $_POST : '';
    if($r['reason'] == 'other'){
       
        $justifications = $conn->sqlQuery("SELECT * justifications WHERE cd_emp = ".$r['cd']." AND dt_just = '".$r['day']."'");
        
        if($justifications == 0){
            $insert = $conn->sqlQuery("INSERT INTO justifications (cd_emp, dt_just, tp_just, ds_just, cd_manager) VALUES ('".$r['cd']."','".$r['day']."','".$r['reason']."','".$r['form']['inputDescriptJustification']."','00')");
                if($insert){
                echo "insert";
            }
        }
    }
    
    
    
}
?>