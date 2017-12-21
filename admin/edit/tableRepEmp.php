<?php
require_once ('security.php');
require_once ('../class/cxo.class.php');
protegePagina();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$cd_emp = (isset($_POST['inputRepTimeEmp'])) ? $_POST['inputRepTimeEmp'] : '';
	$YEARMONTH = (isset($_POST['inputRepTimeMes'])) ? $_POST['inputRepTimeMes'] : '';
};
$conn = new CXO;
$month = substr($YEARMONTH, 4);
$year =  substr($YEARMONTH, 0, -2);
$day = 0;
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$tLate = 0;
$tHora75 = 0;
$tHora100 = 0;
$tBalHora=0;

$DAY = array();

$emp = $conn->fetchArray("SELECT * FROM employees WHERE cd_emp = '$cd_emp' ");
$turn = $conn->fetchArray("SELECT * FROM turns WHERE cd_turn = '".$emp['cd_turno']."' ");
$rows = $conn->sqlQuery("SELECT *, extract(DAY FROM dt_time) as day FROM times WHERE cd_emp  = '$cd_emp' AND extract(YEAR_MONTH FROM dt_time) = '$YEARMONTH'");


while ($row = mysql_fetch_assoc($rows)){
	$DAY[$row['day']] = $row;
};
	
?>
<h3><?php echo $emp['nm_emp'].' - ' ?><?php echo nameMonth($YEARMONTH)?></h3>

<table  class="tableRepTime">
	<tr>
		<th>Dia</th>
		<th>Entrada</th>
		<th>Almoço</th>
		<th>Retorno</th>
		<th>Saída</th>
		<th>Intervalo</th>
		<th>Retorno</th>
		<th></th>
		<th>Hora Extra</th>
		<th>Atraso</th>
	</tr>
<?php
	while($day < $daysInMonth){
		$isHoliday = 0;	
		$day++;
		$sDay = (strlen($day)==1) ? '0'.$day : $day;
		$date = $year.$month.$sDay;
		$isHoliday = $conn->numRows("SELECT * FROM holidays WHERE dt_holiday = '$year-$month-$day' AND cd_store  = '".$emp['cd_store']."' ");
		
		$dayWeek = nameDayWeek($month, $day , $year);
		$dayWeekEng = strtolower(jddayofweek (cal_to_jd(CAL_GREGORIAN, $month, $day, $year), 2));
		
		
		$dif = difference($DAY, $day, $turn, $dayWeekEng, $isHoliday, $date);
		
		
		$tLate = $tLate + $dif['late'];
		$tHora75 = $tHora75 + $dif['hora75'];
		$tHora100 = $tHora100 + $dif['hora100'];
		$tBalHora = $tBalHora + $dif['balHora'];
		
?>
	<tr class="<?php echo ($dayWeek != 'Dom' ? ($day&1 ? 'form-group-grey' : '') : ' form-group-dgrey' )  ?>">
		<td><?php echo $dayWeek." - ".$day ?></td>
		<td><?php showTime($day, 'entry', $DAY);?></td>
		<td><?php showTime($day, 'lunch', $DAY);?></td>
		<td><?php showTime($day, 'elunch', $DAY);?></td>
		<td><?php showTime($day, 'exit', $DAY);?></td>
		<td><?php showTime($day, 'snack', $DAY);?></td>
		<td><?php showTime($day, 'esnack', $DAY);?></td>
		<td><?php echo $dif['justification']; ?></td>
		<td><?php echo ($dif['strHora']<>0) ?  minToHour($dif['strHora']): '' ; ?></td>
		<td><?php echo ($dif['strLate']<>0) ?  minToHour($dif['strLate']): '' ; ?></td>
	</tr>

<?php } ?>
	</table>
	<br class="noprint" />
	<hr class="noprint">
	<table class="tableRepTime">
		<tr>
			<th>Hora 75</th>
			<th>Hora 100</th>
			<th>Atraso</th>
			<th>Folgas</th>
		</tr>
		<tr>
			<td><?php echo minToHour($tHora75); ?></td>
			<td><?php echo minToDSR($tHora100); ?></td>
			<td><?php echo minToHour($tLate); ?></td>
			<!-- <td><?php echo $tBalHora; ?></td> -->
		</tr>
	</table>
	<div class='signature noprint'>
		___________________________________________________
		<?php echo '<center><br/>'.$emp['nm_emp'].'</center>' ?>
	</div>

