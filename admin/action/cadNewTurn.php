<?php
include ('../main/header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();
$conn = new Cxoi;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nmTurn = (isset($_POST['inputNmTurn'])) ? $_POST['inputNmTurn'] : '';
	
	$entryMon = (isset($_POST['inputEntryMon'])) ? $_POST['inputEntryMon'] : '0';
	$lunchMon = (isset($_POST['inputLunchMon'])) ? $_POST['inputLunchMon'] : '0';
	$elunchMon = (isset($_POST['inputElunchMon'])) ? $_POST['inputElunchMon'] : '0';
	$exitMon = (isset($_POST['inputExitMon'])) ? $_POST['inputExitMon'] : '0';
	
	$entryTue = (isset($_POST['inputEntryTue'])) ? $_POST['inputEntryTue'] : '0';
	$lunchTue = (isset($_POST['inputLunchTue'])) ? $_POST['inputLunchTue'] : '0';
	$elunchTue = (isset($_POST['inputElunchTue'])) ? $_POST['inputElunchTue'] : '0';
	$exitTue = (isset($_POST['inputExitTue'])) ? $_POST['inputExitTue'] : '0';
	
	$entryWed = (isset($_POST['inputEntryWed'])) ? $_POST['inputEntryWed'] : '0';
	$lunchWed = (isset($_POST['inputLunchWed'])) ? $_POST['inputLunchWed'] : '0';
	$elunchWed = (isset($_POST['inputElunchWed'])) ? $_POST['inputElunchWed'] : '0';
	$exitWed = (isset($_POST['inputExitWed'])) ? $_POST['inputExitWed'] : '0';
	
	$entryThu = (isset($_POST['inputEntryThu'])) ? $_POST['inputEntryThu'] : '0';
	$lunchThu = (isset($_POST['inputLunchThu'])) ? $_POST['inputLunchThu'] : '0';
	$elunchThu = (isset($_POST['inputElunchThu'])) ? $_POST['inputElunchThu'] : '0';
	$exitThu = (isset($_POST['inputExitThu'])) ? $_POST['inputExitThu'] : '0';
	
	$entryFri = (isset($_POST['inputEntryFri'])) ? $_POST['inputEntryFri'] : '0';
	$lunchFri = (isset($_POST['inputLunchFri'])) ? $_POST['inputLunchFri'] : '0';
	$elunchFri = (isset($_POST['inputElunchFri'])) ? $_POST['inputElunchFri'] : '0';
	$exitFri = (isset($_POST['inputExitFri'])) ? $_POST['inputExitFri'] : '0';
	
	$entrySat = (isset($_POST['inputEntrySat'])) ? $_POST['inputEntrySat'] : '0';
	$lunchSat = (isset($_POST['inputLunchSat'])) ? $_POST['inputLunchSat'] : '0';
	$elunchSat = (isset($_POST['inputElunchSat'])) ? $_POST['inputElunchSat'] : '0';
	$exitSat = (isset($_POST['inputExitSat'])) ? $_POST['inputExitSat'] : '0';
	
	$entrySun = (isset($_POST['inputEntrySun'])) ? $_POST['inputEntrySun'] : '0';
	$lunchSun = (isset($_POST['inputLunchSun'])) ? $_POST['inputLunchSun'] : '0';
	$elunchSun = (isset($_POST['inputElunchSun'])) ? $_POST['inputElunchSun'] : '0';
	$exitSun = (isset($_POST['inputExitSun'])) ? $_POST['inputExitSun'] : '0';
	
	$dayOff = (isset($_POST['inputDayOff'])) ? $_POST['inputDayOff'] : '0';
	
	$result['status'] = 'fail';
	
	if(!empty($nmTurn)){
				
		$canUseName = $conn->numRows("SELECT cd_turn FROM turns WHERE nm_turn = '$nmTurn'");
		if($canUseName == 0){
			
			$insert = $conn->sqlQuery("INSERT INTO turns (	 
															 nm_turn, 
															 entry_mon, lunch_mon, elunch_mon, exit_mon, 
															 entry_tue, lunch_tue, elunch_tue, exit_tue, 
															 entry_wed, lunch_wed, elunch_wed, exit_wed,
															 entry_thu, lunch_thu, elunch_thu, exit_thu,
															 entry_fri, lunch_fri, elunch_fri, exit_fri,
															 entry_sat, lunch_sat, elunch_sat, exit_sat,
															 entry_sun, lunch_sun, elunch_sun, exit_sun,
															 day_off
															 ) 
									   VALUES (				'$nmTurn', 
									   						'$entryMon', '$lunchMon', '$elunchMon', '$exitMon',
									   						'$entryTue', '$lunchTue', '$elunchTue', '$exitTue',
									   						'$entryWed', '$lunchWed', '$elunchWed', '$exitWed',
									   						'$entryThu', '$lunchThu', '$elunchThu', '$exitThu',
									   						'$entryFri', '$lunchFri', '$elunchFri', '$exitFri',
									   						'$entrySat', '$lunchSat', '$elunchSat', '$exitSat',
									   						'$entrySun', '$lunchSun', '$elunchSun', '$exitSun',
									   						'$dayOff'									   						
															)");
								   
			if($insert){
				$result['status'] = 'successNewTurn';	
			}
		}
		else{
			$result['status'] = 'turnUsed';
		}
		
	}
}

?>

<body>
	<?php include('../main/menu.php')
	?>
	<div id="mainCont">
		<?php 
			if($result['status'] == 'successNewTurn'){
				echo '<div class=\'msg-success\'>
						<img class=\'img\' src=\'../../img/success.png\'>
						<label>Turno cadastrado com <b>sucesso</b></label>.
						<a class=\'hrefRepeat\' href=\'../cad/cadNewTurn.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Cadastrar outro turno.</div>
						</a>
					  </div>';				
			} else{
				echo '<div class=\'msg-fail\'>
						<img class=\'img\' src=\'../../img/fail.png\'>
						<label><b>Falha</b> ao cadastrar o turno!</label>.
						<a class=\'hrefRepeat\' href=\'../cad/cadNewTurn.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Tentar novamente.</div>
						</a>
					  </div>';
			}
		?>
	</div>
</body>
</html>
