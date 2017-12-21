<?php
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();

function isTime($time,$is24Hours=true,$seconds=false) {
    $pattern = "/^([1-2][0-3]|[0-1][1-9]):([0-5][0-9])$/";
    if (preg_match($pattern, $time)) {
        return true;
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cd_emp = (isset($_POST['inputCdEmp'])) ? $_POST['inputCdEmp'] : '';
    $YEARMONTH = (isset($_POST['inputYearMonth'])) ? $_POST['inputYearMonth'] : '';
  
    $month = substr($YEARMONTH, 4);
    $year  = substr($YEARMONTH, 0, -2);
    $day = 0;

    $row = (isset($_POST['input'])) ? $_POST['input'] : '';
    $data = (isset($_POST['before'])) ? $_POST['before'] : '';
    
    $result['status'] = 'fail';
    $sqlRows = "";
    $conn = new Cxoi;

    $name_times = ['tm_entry','tm_lunch','tm_elunch','tm_snack','tm_esnack','tm_exit'];
    
    foreach($row as $day => $time){
        
        $dt_time = $year.'-'.$month.'-'.$day;
        
        foreach($name_times as $i => $type){
            
            if(isset($time[$type])){
                if( $time[$type] != ""){
                    if(isTime($time[$type])){
                        $values[$type] = "'".$time[$type].":00'";
                    }else{
                        $result['status'] = "invalidTime";
                        die(json_encode($result));
                    }
                }else{
                    if($time[$type] == '' && $data[$day][$type] != ''){
                        $values[$type] = '"clean"';
                    }else{
                        $values[$type] = 'NULL';
                    }
                }  
            }else{
                $values[$type] = 'NULL';
            }
        }
        
        if(count(array_filter($values)) != 0){
            if(!empty($sqlRows)){
                $sqlRows .= " , ";
            }
            $sqlRows .= " ('".$dt_time."' , ".$cd_emp." , ".$values['tm_entry']." , ".$values['tm_lunch']." , ".$values['tm_elunch']." , ".$values['tm_snack']." , ".$values['tm_esnack']." , ".$values['tm_exit'].")";
        }
    }
    $query = "INSERT INTO times (dt_time, cd_emp, tm_entry, tm_lunch, tm_elunch, tm_snack, tm_esnack, tm_exit) 
								VALUES 				$sqlRows 
								ON DUPLICATE KEY UPDATE 
								tm_entry = IF(VALUES(tm_entry) = 'clean', NULL, IFNULL(VALUES(tm_entry), tm_entry)), 
								tm_lunch = IF(VALUES(tm_lunch) = 'clean', NULL, IFNULL(VALUES(tm_lunch), tm_lunch)), 
								tm_elunch = IF(VALUES(tm_elunch) = 'clean', NULL, IFNULL(VALUES(tm_elunch), tm_elunch)), 
								tm_snack = IF(VALUES(tm_snack) = 'clean', NULL, IFNULL(VALUES(tm_snack), tm_snack)), 
								tm_esnack = IF(VALUES(tm_esnack) = 'clean', NULL, IFNULL(VALUES(tm_esnack), tm_esnack)), 
								tm_exit = IF(VALUES(tm_exit) = 'clean', NULL, IFNULL(VALUES(tm_exit), tm_exit)) 
							  ";
    $conn = new Cxoi;
    echo $query;
    //$insert = $conn->sqlQuery($query);

    if($insert){
        $result['status'] = "successEditTime";
    }else{
        $result['status'] = "failEditTime";
    }

    echo json_encode($result);
    
}

?>