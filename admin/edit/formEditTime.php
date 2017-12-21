<?php
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
require_once ('../class/emonth.php');

protegePagina();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$cd_emp = (isset($_POST['inputSelTimeEmp'])) ? $_POST['inputSelTimeEmp'] : '';
	$YEARMONTH = (isset($_POST['inputSelTimeMes'])) ? $_POST['inputSelTimeMes'] : '';
	
}; 
$conn = new Cxoi;
$month = substr($YEARMONTH, 4);
$year =  substr($YEARMONTH, 0, -2);
$day = 0;
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$time = array();

$eemp = $conn->fetchAssoc('SELECT * FROM employees WHERE cd_emp = '.$cd_emp);

$rows = $conn->sqlQuery("
SELECT *, extract(DAY FROM t.dt_time) as day 
FROM times t
LEFT JOIN justifications j ON t.dt_time = j.dt_just AND t.cd_emp = j.cd_emp
WHERE t.cd_emp  = '$cd_emp' AND extract(YEAR_MONTH FROM t.dt_time) = '$YEARMONTH'");
while ($row = mysqli_fetch_assoc($rows)){
	$time[$row['day']] = $row;
}; 

$M = new eMonth($month, $year, $time, $cd_emp);

?>

<div class="edit_time_emp_info">    
    <div class="col-sm-2 col-sm-offset-1">  
           <img src='../../pic/<?php echo $eemp['ds_pic'] ?>' class='pic_select_emp  img-circle' width="100px"/>
    </div>
    <div class="col-sm-9" style="margin-top:30px">
        <div class="col-sm-2">
            <b> ID: </b><?php echo $eemp['cd_emp']?>
        </div>
        <div class="col-sm-5">
            <b>Nome: </b><?php echo $eemp['nm_emp']?>
        </div>
        <div class="col-sm-5">
            <b>Data de Adimição: </b><?php echo dateBr($eemp['dt_hire'])?>
        </div>
    </div>
</div>
<button type="button" id='saveEditTime' class="btn btn-primary">
    Salvar
</button>
<form class="form-horizontal" role="form" method="post" id="form-editTime" enctype="multipart/form-data">
    
    <input name='inputCdEmp' data-before='a' id='inputCdEmp' type="hidden" value='<?php echo $eemp['cd_emp']?>' class='form-control'/>
    <input name='inputYearMonth' data-before='' id='inputYearMonth' type="hidden" value='<?php echo $YEARMONTH?>' class='form-control'/>

   
	<div class="form-group editTimeTitle">
		<b> 

		<div class="col-sm-offset-1 col-sm-1 ">
			<div class="form-control noInputTitle">
				Entrada
			</div>
		</div>
		<div class="col-sm-1 ">
			<div class="form-control noInputTitle">
				Almoço
			</div>
		</div>
		<div class="col-sm-1 ">
			<div class="form-control noInputTitle">
				Retorno
			</div>
		</div>
        <div class="col-sm-1 ">
            <div class="form-control noInputTitle">
                Intervalo
            </div>
        </div>
        <div class="col-sm-1 ">
            <div class="form-control noInputTitle">
                Retorno
            </div>
        </div>
		<div class="col-sm-1 ">
			<div class="form-control noInputTitle">
				Saída
			</div>
		</div> 
		<div class="col-sm-5 ">
			<div class="form-control noInputTitle">
				Justificativa
			</div>
		</div>
		</b>
	</div>
	<?php		
		while($day < $daysInMonth){
		$day++;
		$dayWeek = nameDayWeek($month, $day , $year);
        $M->cast_line($day);
        }
    ?>
    <div class="form-group editTimeTitle"></div>
</form>
