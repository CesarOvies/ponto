<?php
$store=null;
$emp = $conn->sqlQuery('
		SELECT * FROM employees 
		INNER JOIN stores 
		ON employees.cd_store = stores.cd_store 
		AND employees.is_active = 1
		ORDER BY employees.cd_store, employees.nm_emp'); 
	while($eemp = mysqli_fetch_assoc($emp)){
        if($eemp['cd_emp'] == $cd_emp) {
            $select = 'selected';  
        }else{
            $select = '';  
        };
		if($store == $eemp['cd_store']){
            echo "<option ".$select." value='".$eemp['cd_emp']."'>".$eemp['nm_emp']."</option>";
		}else{
			
			echo "<option style='color:#FFF;background-color:#428bca' disabled>".strtoupper ($eemp['nm_store'])."</option>";
            echo "<option ".$select." value='".$eemp['cd_emp']."'>".$eemp['nm_emp']."</option>";
			$store = $eemp['cd_store'];
		}
    }
?>


