<?php
$month = $conn->sqlQuery('
		SELECT extract(YEAR_MONTH FROM dt_time) as ym 
		FROM times GROUP BY ym ORDER BY ym DESC'); 
	while($emonth = mysqli_fetch_assoc($month)){
        if($emonth['ym'] == (substr($date,0,4).substr($date,5,2))) {
            $select = 'selected';  
        }else{
            $select = '';  
        };
           echo "<option ".$select." value='".$emonth['ym']."'>".nameYearMonth($emonth['ym'])."</option>";
        
	}				
?>