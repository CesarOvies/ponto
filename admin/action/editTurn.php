<?php
include ('../main/header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();
$conn = new Cxoi;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$cd_turn = (isset($_POST['inputEditTurnCd'])) ? $_POST['inputEditTurnCd'] : '';
	$times =   (isset($_POST['inputEdit'])) 	  ? $_POST['inputEdit'] : '';
	$nm_turn = (isset($_POST['inputEditNmTurn'])) ? $_POST['inputEditNmTurn'] : '';
	$day_off = (isset($_POST['inputEditDayOff'])) ? $_POST['inputEditDayOff'] : '';
	
	$result['status'] = 'fail';
	
		
	if (!empty($cd_turn) && !empty($day_off)) {
		
		$canUsePass = $conn -> numRows("SELECT cd_turn FROM turns WHERE nm_turn = '$nm_turn' AND cd_turn <> 'cd_turn ");
		if ($canUsePass == 0) {
			$result['status'] = 'aaa';
			$insert = $conn -> sqlQuery("UPDATE turns SET 
			 nm_turn = '$nm_turn',
			 entry_mon = '".$times['Entry']['Mon']."', 
			 lunch_mon = '".$times['Lunch']['Mon']."', 
			 elunch_mon = '".$times['Elunch']['Mon']."', 
			 exit_mon = '".$times['Exit']['Mon']."', 
			 entry_tue = '".$times['Entry']['Tue']."', 
			 lunch_tue = '".$times['Lunch']['Tue']."', 
			 elunch_tue = '".$times['Elunch']['Tue']."', 
			 exit_tue = '".$times['Exit']['Tue']."', 
			 entry_wed = '".$times['Entry']['Wed']."', 
			 lunch_wed = '".$times['Lunch']['Wed']."', 
			 elunch_wed = '".$times['Elunch']['Wed']."', 
			 exit_wed = '".$times['Exit']['Wed']."',
			 entry_thu = '".$times['Entry']['Thu']."', 
			 lunch_thu = '".$times['Lunch']['Thu']."', 
			 elunch_thu = '".$times['Elunch']['Thu']."', 
			 exit_thu = '".$times['Exit']['Thu']."',
			 entry_fri = '".$times['Entry']['Fri']."', 
			 lunch_fri = '".$times['Lunch']['Fri']."', 
			 elunch_fri = '".$times['Elunch']['Fri']."', 
			 exit_fri = '".$times['Exit']['Fri']."',
			 entry_sat = '".$times['Entry']['Sat']."', 
			 lunch_sat = '".$times['Lunch']['Sat']."', 
			 elunch_sat = '".$times['Elunch']['Sat']."', 
			 exit_sat = '".$times['Exit']['Sat']."',
			 entry_sun = '".$times['Entry']['Sun']."', 
			 lunch_sun = '".$times['Lunch']['Sun']."', 
			 elunch_sun = '".$times['Elunch']['Sun']."', 
			 exit_sun = '".$times['Exit']['Sun']."',
			 day_off = '$day_off'
		
			WHERE cd_turn = '$cd_turn'");

			if ($insert) {
				$result['status'] = 'successEditTurn';
			}
		} else {
			$result['status'] = 'failEditTurn';
		
		}
	}
}

?>

<body>
	<?php include('../main/menu.php')
	?>
	<div id="mainCont">
		<?php 
			if($result['status'] == 'successEditTurn'){
				echo '<div class=\'msg-success\'>
						<img class=\'img\' src=\'../../img/success.png\'>
						<label>Turno editado com <b>sucesso</b></label>.
						<a class=\'hrefRepeat\' href=\'../edit/editTurn.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Editar outro turno.</div>
						</a>
					  </div>';				
			} else{
				echo '<div class=\'msg-fail\'>
						<img class=\'img\' src=\'../../img/fail.png\'>
						<label><b>Falha</b> ao editar o turno!</label>.
						<a class=\'hrefRepeat\' href=\'../edit/editTurn.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Tentar novamente.</div>
						</a>
					  </div>';
			}
		?>
	</div>
</body>
</html>

