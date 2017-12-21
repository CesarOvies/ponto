<?php
include ('../main/header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();
$conn = new Cxoi;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$date =  (isset($_POST['inputHoliDate'])) ? $_POST['inputHoliDate'] : '';
	$name =  (isset($_POST['inputNmHoli'])) ? $_POST['inputNmHoli'] : '';
	$check = (isset($_POST['check'])) ? $_POST['check'] : '';	
	$result['status'] = 'fail';
	
	if($_POST['type'] == 'exclude'){
		if(!empty($date)){

			$clear = $conn->sqlQuery("DELETE FROM holidays WHERE dt_holiday='$date'");
			if($clear){
				$result['status'] = 'excludeSuccess';
			}
		}
	}
	else{	
	if(!empty($date)){

		$clear = $conn->sqlQuery("DELETE FROM holidays WHERE dt_holiday='$date'");
		if($clear){
			
			foreach($check as $store){
				$insert = $conn->sqlQuery("INSERT INTO holidays (dt_holiday, nm_holiday, cd_store) VALUES ('$date', '$name', '$store') ");				   
			}
								   
			if($insert){
				$result['status'] = 'successEditHoli';	
			}
		}
		else{
			$result['status'] = 'holiUsed';
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
			if($result['status'] == 'successEditHoli'){
				echo '<div class=\'msg-success\'>
						<img class=\'img\' src=\'../../img/success.png\'>
						<label>Feriado editado com <b>sucesso</b></label>.
						<a class=\'hrefRepeat\' href=\'../edit/EditHoli.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Editar outro feriado.</div>
						</a>
					  </div>';				
			} elseif($result['status'] == 'excludeSuccess'){
				echo '<div class=\'msg-success\'>
						<img class=\'img\' src=\'../../img/success.png\'>
						<label>Feriado excluído com <b>sucesso</b></label>.
						<a class=\'hrefRepeat\' href=\'../edit/EditHoli.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Editar outro feriado.</div>
						</a>
					  </div>';		
			} else{
				echo '<div class=\'msg-fail\'>
						<img class=\'img\' src=\'../../img/fail.png\'>
						<label><b>Falha</b> ao editar o feriado!</label>.
						<a class=\'hrefRepeat\' href=\'../edit/EditHoli.php\'>
							<img class=\'imgRepeat\' src=\'../../img/repeat.png\'>
							<div>Tentar novamente.</div>
						</a>
					  </div>';
			}
		?>
	</div>
</body>
</html>
